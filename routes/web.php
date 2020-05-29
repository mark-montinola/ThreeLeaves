<?php


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('{path}', "HomeController@index")->where('path', '/([A-z\d-\/_.]+)?/');
Route::get('sidebar', 'SidebarController@index')->name('sidebar.index');
Route::get('module', 'MainMenuController@index')->name('module.index');
Route::get('module/{module_name}', 'MainMenuController@show')->name('module.show');
Route::get('module/{module_name}/{category_name}', 'MainMenuController@showForm')->name('category.show');
Route::get('module/{module_name}/{category_name}/{form_name}', 'FormManagerController@index')->name('form_manager.index');

/**
 * CRUD Operations
 */
// Route::get('module/{module_name}/{category_name}/Item/{method}', 'ItemController@create')->name('item.create');

Route::get('module/{module_name}/{category_name}/{form_name}/{method}', 'FormController@create')->name('form.create');
Route::get('module/{module_name}/{category_name}/{form_name}/{method}/{id}', 'FormController@edit')->name('form.edit');
Route::post('module/{module_name}/{category_name}/{form_name}/{method}', 'FormController@store')->name('form.store');
Route::put('module/{module_name}/{category_name}/{form_name}/{method}/{id}', 'FormController@update')->name('form.update');
Route::delete('module/{module_name}/{category_name}/{form_name}/{method}/{id}', 'FormManagerController@destroy')->name('form_manager.destroy');

// Get Options
Route::get('optionID/{id}', 'FormController@getOptions')->name('form.getOptions');

// Route::delete('form/{form_name}', 'FormManagerController@destroy')->name('form_manger.destroy');


