<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::resource('company', 'CompanyController');

Route::post('company/update', 'CompanyController@update')->name('company.update');

Route::get('company/destroy/{id}', 'CompanyController@destroy');
Route::resource('project', 'ProjectController');

Route::post('project/update', 'ProjectController@update')->name('project.update');

Route::get('project/destroy/{id}', 'ProjectController@destroy');
