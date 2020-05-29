<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\ModelBuilder;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;

class FormController extends BaseController
{
    public function create(Request $request)
    {
        $form_name = $request->form_name;
        $method = $request->method;
        $id = null;
        $form_fields = $this->getFormFields($form_name, $method, $id);
        return $form_fields;
    }

    public function edit(Request $request)
    {
        $form_name = $request->form_name;
        $method = $request->method;
        $id = $request->id;
        return $this->getFormFields($form_name, $method, $id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $module_name, $category_name, $form_name, $method)
    {
        // Get Form ID
        $form_id = $this->getFormID($form_name);
        $getFields = $this->getFields($form_id, $method);
        $fields = $getFields['fields'];
        $tables = $getFields['tables'];
        $id = null;
        $error = false;
        DB::beginTransaction();
        $t = array_keys($tables);
        //Filter by route table
        for ($i = 0; $i < count($t); $i++) {
            if (!$request[$t[$i]]) continue;
            $validation = array();
            $primary_key = array();
            $fillable = array();
            $guarded = array();
            $fill = array();
            $f = array_keys($fields[$t[$i]]);
            for ($ii = 0; $ii < count($request[$t[$i]]); $ii++) {
                for ($iii = 0; $iii < count($f); $iii++) {
                    $k = $fields[$t[$i]][$f[$iii]];
                    if (array_key_exists("validation", $k)) {
                        if ($k['validation'] != '') {
                            $validation = array_merge($validation, [$t[$i] . ".*.data." .$f[$iii] => $k['validation']]);
                        }
                    }
                    if (array_key_exists("fillable", $k)) {
                        if ($k['fillable'] == 'Y') {
                            $fillable = array_merge($fillable, [$f[$iii]]);
                        }
                    }
                    if (array_key_exists("guarded", $k)) {
                        if ($k['guarded'] == 'Y') {
                            $guarded = array_merge($guarded, [$f[$iii]]);
                        }
                    }
                    if (array_key_exists("primaryKey", $k)) {
                        if ($k['primaryKey'] == true) {
                            // if (count($request[$t[$i]][$ii]['data'][$f[$iii]]) > 1) {
                            if (is_array($request[$t[$i]][$ii]['data'][$f[$iii]]) && count($request[$t[$i]][$ii]['data'][$f[$iii]]) > 1) {
                                $primary_key = array_merge($primary_key, [$f[$iii] => $request[$t[$i]][$ii]['data'][$f[$iii]]['key']]);
                            } else {
                                $primary_key = array_merge($primary_key, [$f[$iii] => $request[$t[$i]][$ii]['data'][$f[$iii]]]);
                            }
                        }
                    }
                    if ($i > 0 && $f[$iii] == 'id') {
                        $a = $request[$t[$i]];
                        $a[$ii]['data'][$f[$iii]] = $id;
                        $request->merge([ [$t[$i]][0] => $a ]);
                    }
                    // if (count($request[$t[$i]][$ii]['data'][$f[$iii]]) > 1) {
                    if (is_array($request[$t[$i]][$ii]['data'][$f[$iii]]) && count($request[$t[$i]][$ii]['data'][$f[$iii]]) > 1) {
                        $fill = array_merge($fill, [$f[$iii] => $request[$t[$i]][$ii]['data'][$f[$iii]]['key']]);
                    } else {
                        $fill = array_merge($fill, [$f[$iii] => $request[$t[$i]][$ii]['data'][$f[$iii]]]);
                    }
                }
            }

            $this->validate($request, $validation);
            $model = ModelBuilder::fromTable($t[$i]);

            // Start: Check Duplicate
            $retrieve = $model
                ->where($primary_key)
                ->first();
            if ($retrieve) {
                $duplicate = array();
                $p = array_keys($primary_key);
                for ($iiii = 0; $iiii < count($p); $iiii++) {
                    $a = $t[$i] . '.' . $ii .'.' . 'data.' . $p[$iiii];
                    $duplicate = array_merge($duplicate, [$a => [0 => 'Duplicate data']]);
                }
                return response()->json($duplicate, 404);
            }
            // End: Check Duplicate

            $saved = $model->fillable($fillable)
                ->fill($fill)
                ->save();
            if (!$saved) {
                $error = true;
                break;
            }

            // Get ID
            if ($i == 0) {
                $id = $model->id;
            }
        }
        if ($error) {
            DB::rollback();
        } else {
            DB::commit();
        }
        return $model;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $module_name, $category_name, $form_name, $method, $id)
    {
        // Get Form ID
        $form_id = $this->getFormID($form_name);
        $getFields = $this->getFields($form_id, $method);
        $fields = $getFields['fields'];
        $tables = $getFields['tables'];
        $error = false;
        DB::beginTransaction();
        $t = array_keys($tables);
        for ($i = 0; $i < count($t); $i++) {
            if (!$request[$t[$i]]) continue;
            $f = array_keys($fields[$t[$i]]);
            // Start: Delete
            for ($ii = 0; $ii < count($request[$t[$i]]); $ii++) {
                if ($request[$t[$i]][$ii]['status'] == 'Deleted!') {
                    $primary_key = array();
                    for ($iii = 0; $iii < count($f); $iii++) {
                        $k = $fields[$t[$i]][$f[$iii]];
                        if (array_key_exists("primaryKey", $k)) {
                            if ($k['primaryKey'] == true) {
                                if (count($request[$t[$i]][$ii]['data'][$f[$iii]]) > 1) {
                                    $primary_key = array_merge($primary_key, [$f[$iii] => $request[$t[$i]][$ii]['data'][$f[$iii]]['key']]);
                                } else {
                                    $primary_key = array_merge($primary_key, [$f[$iii] => $request[$t[$i]][$ii]['data'][$f[$iii]]]);
                                }
                            }
                        }
                    }
                    $model = ModelBuilder::fromTable($t[$i]);
                    $saved = $model
                        ->where($primary_key)
                        ->delete();
                    if (!$saved) {
                        $error = true;
                        break;
                    }
                }
            }
            // End: Delete

            // Start: Insert
            for ($ii = 0; $ii < count($request[$t[$i]]); $ii++) {
                if ($request[$t[$i]][$ii]['status'] == 'NewModified!') {
                    $validation = array();
                    $primary_key = array();
                    $fillable = array();
                    $guarded = array();
                    $fill = array();
                    for ($iii = 0; $iii < count($f); $iii++) {
                        $k = $fields[$t[$i]][$f[$iii]];
                        if (array_key_exists("validation", $k)) {
                            if ($k['validation'] != '') {
                                $validation = array_merge($validation, [$t[$i] . ".*.data." .$f[$iii] => $k['validation']]);
                            }
                        }
                        if (array_key_exists("fillable", $k)) {
                            if ($k['fillable'] == 'Y') {
                                $fillable = array_merge($fillable, [$f[$iii]]);
                            }
                        }
                        if (array_key_exists("guarded", $k)) {
                            if ($k['guarded'] == 'Y') {
                                $guarded = array_merge($guarded, [$f[$iii]]);
                            }
                        }
                        if (array_key_exists("primaryKey", $k)) {
                            if ($k['primaryKey'] == true) {
                                if (is_array($request[$t[$i]][$ii]['data'][$f[$iii]]) && count($request[$t[$i]][$ii]['data'][$f[$iii]]) > 1) {
                                    $primary_key = array_merge($primary_key, [$f[$iii] => $request[$t[$i]][$ii]['data'][$f[$iii]]['key']]);
                                } else {
                                    $primary_key = array_merge($primary_key, [$f[$iii] => $request[$t[$i]][$ii]['data'][$f[$iii]]]);
                                }
                            }
                        }
                        if (is_array($request[$t[$i]][$ii]['data'][$f[$iii]]) && count($request[$t[$i]][$ii]['data'][$f[$iii]]) > 1) {
                            $fill = array_merge($fill, [$f[$iii] => $request[$t[$i]][$ii]['data'][$f[$iii]]['key']]);
                        } else {
                            $fill = array_merge($fill, [$f[$iii] => $request[$t[$i]][$ii]['data'][$f[$iii]]]);
                        }
                    }
                    $this->validate($request, $validation);
                    $model = ModelBuilder::fromTable($t[$i]);

                    // Start: Check Duplicate
                    $retrieve = $model
                        ->where($primary_key)
                        ->first();
                    if ($retrieve) {
                        $duplicate = array();
                        $p = array_keys($primary_key);
                        for ($iiii = 0; $iiii < count($p); $iiii++) {
                            $a = $t[$i] . '.' . $ii . '.' . 'data.' . $p[$iiii];
                            $duplicate = array_merge($duplicate, [$a => [0 => 'Duplicate data']]);
                        }
                        return response()->json($duplicate, 404);
                    }
                    // End: Check Duplicate

                    $saved = $model->fillable($fillable)
                        ->fill($fill)
                        ->save();
                    if (!$saved) {
                        $error = true;
                        break;
                    }
                }
            }
            // End: Insert
            
            // Start: Update
            for ($ii = 0; $ii < count($request[$t[$i]]); $ii++) {
                $validation = array();
                $primary_key = array();
                $fill = array();
                if ($request[$t[$i]][$ii]['status'] == 'DataModified!') {
                    for ($iii = 0; $iii < count($f); $iii++) {
                        $k = $fields[$t[$i]][$f[$iii]];
                        if (array_key_exists("validation", $k)) {
                            if ($k['validation'] != '') {
                                $validation = array_merge($validation, [$t[$i] . ".*.data." .$f[$iii] => $k['validation']]);
                            }
                        }
                        if (array_key_exists("primaryKey", $k)) {
                            if ($k['primaryKey'] == true) {
                                if (is_array($request[$t[$i]][$ii]['data'][$f[$iii]]) && count($request[$t[$i]][$ii]['data'][$f[$iii]]) > 1) {
                                    $primary_key = array_merge($primary_key, [$f[$iii] => $request[$t[$i]][$ii]['data'][$f[$iii]]['key']]);
                                } else {
                                    $primary_key = array_merge($primary_key, [$f[$iii] => $request[$t[$i]][$ii]['data'][$f[$iii]]]);
                                }
                            }
                        }
                        if (is_array($request[$t[$i]][$ii]['data'][$f[$iii]]) &&  count($request[$t[$i]][$ii]['data'][$f[$iii]]) > 1) {
                            $fill = array_merge($fill, [$f[$iii] => $request[$t[$i]][$ii]['data'][$f[$iii]]['key']]);
                        } else {
                            $fill = array_merge($fill, [$f[$iii] => $request[$t[$i]][$ii]['data'][$f[$iii]]]);
                        }
                    }
                    $this->validate($request, $validation);
                    $model = ModelBuilder::fromTable($t[$i]);
                    $saved = $model
                        ->where($primary_key)
                        ->update($fill);
                    if (!$saved) {
                        $error = true;
                        break;
                    }
                }
            }
            // End: Update
        }
        if ($error) {
            DB::rollback();
        } else {
            DB::commit();
        }
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

    /**
     * Generate design either on FormManager or Form 
     *  
     * @param string $form_name
     * @param string $form_type [FormManager, Form]
     * @param string $method [add, edit]
     */
    public function getFormFields($form_name, $method = null, $id = null) 
    {
        $form_id = $this->getFormID($form_name);
        // Get KRAM Form
        $kram_form = DB::table('kram_form')
            ->join('kram_module', 'kram_form.module', '=', 'kram_module.id')
            ->join('kram_category', 'kram_form.category', '=', 'kram_category.id')
            ->select('kram_form.id', 'kram_module.description as module', 'kram_category.description as category', 'kram_form.presentation_style')
            ->where('kram_form.id', '=', $form_id)
            ->get();
        $kram_form = $kram_form[0];
        $module = $kram_form->module;
        $category = $kram_form->category;

        // Set Breadcrumbs
        $breadcrumbs = $this->getBreadCrumbs($module, $category, $form_name, $method, $id);
        
        // Get Fields
        $getFields = $this->getFields($form_id, $method);
        // return $getFields;
        $fields = $getFields['fields'];
        $tables = $getFields['tables'];
        $t = array_keys($tables);

        // Get Columns and Columns that has optionID
        $columns = [];
        $columns_opt = [];
        for ($i = 0; $i < count($t); $i++) {
            $f = array_keys($fields[$t[$i]]);
            for ($ii = 0; $ii < count($fields[$t[$i]]); $ii++) {
                $columns[$t[$i]][$ii] = $f[$ii];
                if (array_key_exists('optionID', $fields[$t[$i]][$f[$ii]])) {
                    $columns_opt[$t[$i]][$f[$ii]] = $fields[$t[$i]][$f[$ii]];
                }
            }
        }

        // Get Items
        $items = [];
        $items_temp = [];
        for ($i = 0; $i < count($t); $i++) {
            if ($method == 'edit') {
                $a = DB::table($t[$i]);
                $a->select($columns[$t[$i]]);
                $a->where('id', '=', $id);
                $items_temp[$t[$i]] = $a->get();
                $items[$t[$i]] = [];
                $status = 'NotModified!';
                for($ii = 0; $ii < count($items_temp[$t[$i]]); $ii++) {
                    $items[$t[$i]][$ii]["data"] = $items_temp[$t[$i]][$ii];
                    $items[$t[$i]][$ii]["status"] = $status;
                    if (count($columns_opt) > 0) {
                        if (array_key_exists($t[$i], $columns_opt)) {
                            $c = array_keys($columns_opt[$t[$i]]);
                            for ($iii = 0; $iii < count($c); $iii++) {
                                $key = $c[$iii];
                                $options = $columns_opt[$t[$i]][$key]['options'];
                                $value = $items[$t[$i]][$ii]["data"]->$key;
                                $data = collect($options)->firstWhere("key", $value);
                                // Not found
                                if (!is_object($data)) {
                                    $items[$t[$i]][$ii]["data"]->$key = $value;
                                } else {
                                    $items[$t[$i]][$ii]["data"]->$key = ["key" => $data->key, "value" => $data->value];
                                }
                            }
                        }
                    }
                }
            } else {
                // Create
                $status = 'New!';
                $items[$t[$i]] = [];
                if ($tables[$t[$i]]['presentationStyle'] !== 'Tabular') {
                    $a = [];
                    $f = array_keys($fields[$t[$i]]);
                    for($ii = 0; $ii < count($f); $ii++) {
                        $a[$f[$ii]] = null;
                    }
                    $items[$t[$i]][0]["data"] = $a;
                    $items[$t[$i]][0]["status"] = $status;
                }
            }
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
            'properties' => $kram_form,
            'tables' => $tables,
            'fields' => $fields, 
            'items' => $items,
            'id' => $id
        );
        return $kram;
    }

    public function getFields($form_id, $method)
    {
        // Get KRAM Form KDW
        $kram_form_tables = DB::table('kram_form_tables')
            ->where('form_id', '=', $form_id)
            ->orderBy('kdw')
            ->get();

        /**
         * Get Table Schema
         */
        $schema = [];
        $tables = [];
        for ($i = 0; $i < count($kram_form_tables); $i++) {
            $schema[$kram_form_tables[$i]->table] = DB::select("describe " . $kram_form_tables[$i]->table);
            $tables[$kram_form_tables[$i]->table]['description'] = $kram_form_tables[$i]->description;
            $tables[$kram_form_tables[$i]->table]['presentationStyle'] = $kram_form_tables[$i]->presentation_style;
        }
        $t = array_keys($tables);

        /**
         * Get Form Field Properties in kram_form_fields
         */
        $form = [];
        for ($i = 0; $i < count($kram_form_tables); $i++) {
            $form[$i] = DB::table('kram_form_fields')
            ->select('column_name', 'field_properties')
            ->where('form_id', '=', $form_id)
            ->where('kdw', '=', $kram_form_tables[$i]->kdw)
            ->orderBy('order')
            ->get();
        }

        $form_fields = [];
        for ($i = 0; $i < count($form); $i++) {
            for ($ii = 0; $ii < count($form[$i]); $ii++) {
                $form_fields[$t[$i]][$ii] = json_decode($form[$i][$ii]->field_properties, true);
                if (array_key_exists("key", $form_fields[$t[$i]][$ii])) {
                    //Verify Key with Column Name
                    if ($form_fields[$t[$i]][$ii]['key'] != $form[$i][$ii]->column_name) {
                        //Raise an error!
                    }
                } else {
                    $form_fields[$t[$i]][$ii]['key'] = $form[$i][$ii]->column_name;
                }
            }
        }

        /**
         * Compare the two object Form Fields and Schema.
         *  - It must set default properties if the required key is not been set.
         *  - Properties will override the default values.
         */
        $exclude = ['created_by', 'updated_by', 'created_at', 'updated_at', 'version'];
        $fields_arr = [];
        $isFound = false;
        for ($i = 0; $i < count($schema); $i++) {
            $fields = [];
            for ($ii = 0; $ii < count($schema[$t[$i]]); $ii++) {
                if (!in_array($schema[$t[$i]][$ii]->Field, $exclude, true)) {
                    /**
                     * Schema Example:
                     * Extra = auto_increment
                     * Default: null
                     * Extra: "auto_increment"
                     * Field: "id"
                     * Key: "PRI"
                     * Null: "NO"
                     * Type: "int(10) unsigned"
                     */
                    
                    $key = $schema[$t[$i]][$ii]->Field;
                    if (count($form_fields) > 0) {
                        if (array_key_exists($t[$i], $form_fields)) {
                            for ($iii = 0; $iii < count($form_fields[$t[$i]]); $iii++) {
                                $key_temp = $form_fields[$t[$i]][$iii]['key'];
                                if ($key == $key_temp) {
                                    // array_push($fields, $form_fields[$t[$i]][$iii]);
                                    $fields[$key] = $form_fields[$t[$i]][$iii];
                                    $isFound = true;
                                    break;
                                }
                            }
                        }
                    }

                    if ($isFound) {
                        $isFound = false;
                    } else {
                        // array_push($fields, ["key" => $key]);
                        $fields[$key] = ["key" => $key];
                    }

                    /**
                     * Set Default Field Properties
                     */
                    // Disable Fields that has auto increment
                    if ($schema[$t[$i]][$ii]->Extra == 'auto_increment') {
                        $fields[$key]['disabled'] = true;
                    }
    
                    // Disable Fields that has primary key(PRI) or multiple primary key (MUL)
                    if ($method == "edit" && ($schema[$t[$i]][$ii]->Key == 'PRI' || $schema[$t[$i]][$ii]->Key == 'MUL')) {
                        $fields[$key]['guarded'] = true;
                    }
    
                    /**
                     * Laravel Properties
                     */
                    if ($schema[$t[$i]][$ii]->Key == 'PRI') {$fields[$key]['primaryKey'] = true;}
                    if (!array_key_exists("fillable", $fields[$key])) {$fields[$key]['fillable'] = true;}
                    if (!array_key_exists("guarded", $fields[$key]) && $method == "edit") {$fields[$key]['guarded'] = false;}
                    if (!array_key_exists("validation", $fields[$key])) {
                        if ($schema[$t[$i]][$ii]->Null == 'NO' && $schema[$t[$i]][$ii]->Extra != 'auto_increment') {
                            $fields[$key]['validation'] = 'required';
                        }
                    } else {
                        $pos = strpos($fields[$key]['validation'], 'required');
                        if (!$pos) {
                            if ($schema[$t[$i]][$ii]->Null == 'NO' && $schema[$t[$i]][$ii]->Extra != 'auto_increment') {
                                $fields[$key]['validation'] = $fields[$key]['validation'] . '|required';
                            }
                        }
                    }
    
                    /**
                     * Vue Properties
                     */
                    if (!array_key_exists("maxlength", $fields[$key])) {
                        $a = $schema[$t[$i]][$ii]->Type;
                        $maxlength = strpos($a, '(') > 0 ? (float)substr($a, strpos($a, '(') + 1, (strpos($a, ')') - strpos($a, '(')) - 1) : null;
                        $fields[$key]['maxlength'] = $maxlength;
                    }

                    // Object Field: Replace the key
                    if (array_key_exists("objectField", $fields[$key])) {$fields[$key]['key'] = $fields[$key]['objectField'];}
                    if (!array_key_exists("element", $fields[$key])) {$fields[$key]['element'] = 'input';}
                    if (!array_key_exists("customLabel", $fields[$key])) {$fields[$key]['customLabel'] = false;}
                    if (array_key_exists("optionID", $fields[$key])) {
                        $option_id = $fields[$key]['optionID'];
                        $data = DB::table('kram_select_options')
                            ->select('sql')
                            ->where('id', '=', $option_id)
                            ->get();
                        $sql = $data[0]->sql;
                        $data = collect(DB::select(DB::raw($sql)));
                        // Note: keyBy will result to object
                        // $data = collect(DB::select($sql))->keyBy('key');
                        $fields[$key]['options'] = $data;
                    }

                    /**
                     * Custom Properties
                     */
                    if (!array_key_exists("type", $fields[$key])) {
                        $a = $schema[$t[$i]][$ii]->Type;
                        $type = strpos($a, '(') > 0 ? substr($a, 0, strpos($a, '(')) : $a;
                        $fields[$key]['type'] = $type;
                    }
                    if (!array_key_exists("inputType", $fields[$key])) {
                        $text_arr = ['CHAR','VARCHAR','BINARY','VARBINARY','TINYBLOB','TINYTEXT','TEXT','BLOB','MEDIUMTEXT','MEDIUMBLOB','LONGTEXT','LONGBLOB'];
                        $number_arr = ['BIT','TINYINT','BOOL','BOOLEAN','SMALLINT','MEDIUMINT','INT','INTEGER','BIGINT','FLOAT','FLOAT','DOUBLE','DOUBLE PRECISION','DECIMAL','DEC'];
                        $data_arr = ['DATE','DATETIME','TIMESTAMP','TIME','YEAR'];
                        if (in_array(strtoupper($type), $text_arr)) {
                            $fields[$key]['inputType'] = 'text';
                        }
                        if (in_array(strtoupper($type), $number_arr)) {
                            $fields[$key]['inputType'] = 'number';
                        }
                        if (in_array(strtoupper($type), $data_arr)) {
                            $fields[$key]['inputType'] = 'date';
                        }
                    }

                    // return $fields;
                }
            }
            $fields_arr[$t[$i]] = $fields;
        }
        return ['tables' => $tables, 'fields' => $fields_arr];
    }

    public function getOptions($optionID) {
        $data = DB::table('kram_select_options')
            ->select('sql')
            ->where('id', '=', $optionID)
            ->get();
        $sql = $data[0]->sql;
        $data = collect(DB::select(DB::raw($sql)));
        return $data;
    }
}
