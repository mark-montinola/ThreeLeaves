<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\ModelBuilder;
use Illuminate\Database\QueryException;

class FormManagerController extends BaseController
{
    public function index(Request $request)
    {
        $form_name = $request->form_name;
        $form_id = $this->getFormID($form_name);
        
        // Get KRAM Form
        $kram_form = DB::table('kram_form')
            ->join('kram_module', 'kram_form.module', '=', 'kram_module.id')
            ->join('kram_category', 'kram_form.category', '=', 'kram_category.id')
            ->select('kram_form.id', 'kram_module.description as module', 'kram_category.description as category', 'kram_form.route_vue')
            ->where('kram_form.id', '=', $form_id)
            ->get();
        $kram_form = $kram_form[0];
        $module = $kram_form->module;
        $category = $kram_form->category;
        $route_vue = json_decode($kram_form->route_vue, true);
        // $form = json_decode($kram_form->route_vue, true);
        // $form = [];
        // Set Breadcrumbs

        // return $kram_form;

        $breadcrumbs = $this->getBreadCrumbs($module, $category, $form_name);

        // Get KRAM Form KDW
        $kram_form_tables = DB::table('kram_form_tables')
            ->where('form_id', '=', $form_id)
            ->where('kdw', '=', 'KDW01')
            ->orderBy('kdw')
            ->get();
        
        // Get Form Field Properties
        $form_tables = [];
        for ($i = 0; $i < count($kram_form_tables); $i++) {
            $form_tables[$i] = DB::table('kram_form_fields')
            ->select('column_name', 'field_properties_fm AS field_properties') // Note: This is Field Properties FM (Form Manager)
            ->where('form_id', '=', $form_id)
            ->where('kdw', '=', $kram_form_tables[$i]->kdw)
            ->orderBy('order')
            ->get();
        }
        
        $form_fields = [];
        if (count($form_tables) > 0) {
            for ($i = 0; $i < count($form_tables[0]); $i++) {
                $form_fields[$i] = json_decode($form_tables[0][$i]->field_properties, true);
                if (array_key_exists("key", $form_fields[$i])) {
                    //Verify Key with Column Name
                    if ($form_fields[$i]['key'] != $form_tables[0][$i]->column_name) {
                        //Raise an error!
                    }
                } else {
                    $form_fields[$i]['key'] = $form_tables[0][$i]->column_name;
                }
            }
        }

        // Get Table Schema
        $schema = [];
        if (count($kram_form_tables) > 0) {
            for ($i = 0; $i < count($kram_form_tables); $i++) {
                $schema[$i] = DB::select("describe " . $kram_form_tables[$i]->table);
            }
            $schema = $schema[0];
        }
        
        $exclude = ['created_by', 'updated_by', 'created_at', 'updated_at', 'version'];
        $fields = [];
        $isFound = false;
        for ($i = 0; $i < count($schema); $i++) {
            if (!in_array($schema[$i]->Field, $exclude, true)) {
                $key = $schema[$i]->Field;
                for ($ii = 0; $ii < count($form_fields); $ii++) {
                    $key_temp = $form_fields[$ii]['key'];
                    if ($key == $key_temp) {
                        $fields[$i] = $form_fields[$ii];
                        $isFound = true;
                        break;
                    }
                }
                if ($isFound) {
                    $isFound = false;
                } else {
                    $fields[$i]['key'] = $key;
                }
            }
        }

        // Set Default Properties
        for ($i = 0; $i < count($fields); $i++) {
            /**
             * Vue Properties
             */
            if (!array_key_exists("sortable", $fields[$i])) {$fields[$i]['sortable'] = true;}
            if (array_key_exists("optionID", $fields[$i])) {
                $option_id = $fields[$i]['optionID'];
                $data = DB::table('kram_select_options')
                    ->select('sql')
                    ->where('id', '=', $option_id)
                    ->get();
                $sql = $data[0]->sql;
                // $data = collect(DB::select(DB::raw($sql)));
                // Note: keyBy will result to object
                $data = collect(DB::select($sql))->keyBy('key');
                $fields[$i]['options'] = $data;
            }
        }

        // Get Columns
        $columns = [];
        $columns_opt = [];
        $ctr = 0;
        for ($i = 0; $i < count($fields); $i++) {
            $columns[$i] = $fields[$i]['key'];
            if (array_key_exists('optionID', $fields[$i])) {
                $columns_opt[$ctr] = $fields[$i];
                $ctr++;
            }
        }

        // Get Items
        $items = [];
        if (count($kram_form_tables) > 0) {
            for ($i = 0; $i < count($kram_form_tables); $i++) {
                $items[$i] = DB::table($kram_form_tables[$i]->table);
                $items[$i] = $items[$i]->select($columns)->get();
                // Compare with Fields
                for($ii = 0; $ii < count($items[$i]); $ii++) {
                    for ($iii = 0; $iii < count($columns_opt); $iii++) {
                        $key = $columns_opt[$iii]['key'];
                        $options = $columns_opt[$iii]['options'];
                        $value = $items[$i][$ii]->$key;
                        $data = collect($options)->where("key", '=', $value);
                        // Not found
                        if (count($data) == 0) {
                            $items[$i][$ii]->$key = $value;
                        } else {
                            $items[$i][$ii]->$key = $data[$value]->value;
                        }
                    }
                }
            }
            $items = $items[0];
        }
        
        // Get Users Access
        $users_access = DB::table('users_access')
            ->select('access', 'permission')
            ->where('id', '=', '1')
            ->where('form_id', '=', $form_id)
            ->get();
        if (count($users_access) > 0) {
            $users_access = $users_access[0];
            $users_access->permission = json_decode($users_access->permission, true);
        }

        // Set to KRAM Object
        $kram = array(
            'users_access' => $users_access,
            'breadcrumbs' => $breadcrumbs,
            'route_vue' => $route_vue,
            'fields' => $fields, 
            'items' => $items,
        );

        return $kram;
    }

    /**
     * Get Form ID
     * 
     * @param string $form_name
     */
    public function getFormID($form_name)
    {
        $kram_form = DB::table('kram_form')
            ->where('description', '=', $form_name)
            ->get();
        return $kram_form[0]->id;
    }

    public function destroy(Request $request, $module_name, $category_name, $form_name, $method, $id)
    {
        // Get Form ID
        $form_id = $this->getFormID($form_name);
        $getFields = $this->getTables($form_id);
        $tables = $getFields['tables'];
        $model = ModelBuilder::fromTable($tables[0])
            ->where('id', '=', $id)
            ->delete();
        return ['message' => 'Deleted Successfully'];
    }

    public function getTables($form_id)
    {
        // Get KRAM Form KDW
        $kram_form_tables = DB::table('kram_form_tables')
            ->where('form_id', '=', $form_id)
            ->orderBy('kdw')
            ->get();

        /**
         * Get Table
         */
        $tables = [];
        for ($i = 0; $i < count($kram_form_tables); $i++) {
            $tables[$i] = $kram_form_tables[$i]->table;
        }
        return ['tables' => $tables];
    }
}