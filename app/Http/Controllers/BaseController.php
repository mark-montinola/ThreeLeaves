<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function getBreadCrumbs($module = null, $category = null, $form_name = null, $method = null, $id = null)
    {
        $breadcrumbs = [];
        array_push($breadcrumbs, ['name' => 'Module', 'display' => 'Module', 'path' => '/module']);
        if ($module !== null) {
            array_push($breadcrumbs, ['name' => $module, 'display' => $module, 'path' => "/module/{$module}"]);
        }
        if ($category !== null) {
            array_push($breadcrumbs, ['name' => $category, 'display' => $category, 'path' => "/module/{$module}/{$category}"]);
        }
        if ($form_name !== null) {
            array_push($breadcrumbs, ['name' => $form_name, 'display' => $form_name, 'path' => "/module/{$module}/{$category}/{$form_name}"]);
        }
        if ($method == 'create') {
            array_push($breadcrumbs, ['name' => 'Create', 'display' => "Create {$form_name}", 'path' => "/module/{$module}/{$category}/{$form_name}/{$method}"]);
        }
        if ($method == 'edit') {
            array_push($breadcrumbs, ['name' => 'Edit', 'display' => "Edit {$form_name}", 'path' => "/module/{$module}/{$category}/{$form_name}/{$method}/{$id}"]);
        }
        return $breadcrumbs;
    }
}
