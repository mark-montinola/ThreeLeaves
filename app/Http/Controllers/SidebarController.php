<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SidebarController extends Controller
{
    /**
     * Get menu details
     *
     * @param  string  login ID
     * @return kram object
     */
    public function index(Request $request)
    {
        // Get Module
        $module_name = $request->module_name;
        $kram_module = DB::table('kram_module')
            ->join('kram_form', 'kram_module.id', '=', 'kram_form.module')
            ->select('kram_module.id', 'kram_module.description', 'kram_module.icon')
            ->where('kram_module.active', '=' , 'Y')
            ->where('kram_module.description', '=' , $module_name)
            ->groupBy('kram_module.id', 'kram_module.description', 'kram_module.icon')
            ->orderBy('kram_module.order')
            ->get();

        $menu = array();
        for ($i = 0; $i < count($kram_module); $i++) {
            $menu[$i] = $kram_module[$i];
        }
        return $menu;
    }
}
