<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
// use App\Http\Controllers\BaseController;

class MainMenuController extends BaseController
{
    public function index()
    {
        // Get Module
        $first = DB::table('kram_module')
            ->select('kram_module.id', 'kram_module.description', 'kram_module.icon', 'kram_module.remarks')
            ->where('kram_module.id', '=' , 'FAV');

        $kram_module = DB::table('kram_module')
            ->join('kram_form', 'kram_module.id', '=', 'kram_form.module')
            ->select('kram_module.id', 'kram_module.description', 'kram_module.icon', 'kram_module.remarks')
            ->where('kram_module.active', '=' , 'Y')
            ->groupBy('kram_module.id', 'kram_module.description', 'kram_module.icon', 'kram_module.remarks')
            ->orderBy('kram_module.order')
            ->union($first)
            ->get();

        $breadcrumbs = $this->getBreadCrumbs();

        // $breadcrumbs = [
        //     ['name' => 'Module', 'display' => 'Module', 'path' => '/module']
        // ];

        $kram = array(
            'data' => $kram_module,
            'breadcrumbs' => $breadcrumbs
        );

        return $kram;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($module)
    {
        // Get Category
        $kram_category = DB::table('kram_category')
            ->select('kram_category.id', 'kram_category.description', 'kram_category.icon', 'kram_category.remarks')
            ->orderBy('kram_category.order')
            ->get();

        // $breadcrumbs = app('App\Http\Controllers\BaseController')->getBreadCrumbs($module);
        $breadcrumbs = $this->getBreadCrumbs($module);

        // $breadcrumbs = [
        //     ['name' => 'Module', 'display' => 'Module', 'path' => '/module'],
        //     ['name' => $module, 'display' => $module, 'path' => "/module/{$module}"]
        // ];

        $kram = array(
            'module' => $module,
            'data' => $kram_category,
            'breadcrumbs' => $breadcrumbs
        );

        return $kram;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showForm($module, $category)
    {
        // Get Category
        $kram_form = DB::table('kram_form')
            ->join('kram_module', 'kram_form.module', '=', 'kram_module.id')
            ->join('kram_category', 'kram_form.category', '=', 'kram_category.id')
            ->select('kram_form.id', 'kram_form.description', 'kram_form.icon', 'kram_form.remarks')
            ->where([
                ['kram_module.active', '=' , 'Y'],
                ['kram_form.active', '=' , 'Y'],
                ['kram_module.description', '=' , $module],
                ['kram_category.description', '=' , $category],
            ])
            ->groupBy('kram_form.id', 'kram_form.description', 'kram_form.icon', 'kram_form.remarks')
            ->orderBy('kram_form.order')
            ->get();

        $breadcrumbs = [
            ['name' => 'Module', 'display' => 'Module', 'path' => '/module'],
            ['name' => $module, 'display' => $module, 'path' => "/module/{$module}"],
            ['name' => $category, 'display' => $category, 'path' => "/module/{$module}/{$category}"]
        ];

        $kram = array(
            'module' => $module,
            'category' => $category, 
            'data' => $kram_form,
            'breadcrumbs' => $breadcrumbs
        );

        return $kram;
    }
}
