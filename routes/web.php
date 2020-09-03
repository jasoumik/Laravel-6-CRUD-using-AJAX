<?php

use Illuminate\Support\Facades\Route;

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

//company

Route::resource('company', 'CompanyController');

Route::post('company/update', 'CompanyController@update')->name('company.update');

Route::get('company/destroy/{id}', 'CompanyController@destroy');

//project

Route::resource('project', 'ProjectController');

Route::post('project/update', 'ProjectController@update')->name('project.update');

Route::get('project/destroy/{id}', 'ProjectController@destroy');


//company_owner
Route::resource('company_owner', 'CompanyOwnerController');

Route::post('company_owner/update', 'CompanyOwnerController@update')->name('company_owner.update');

Route::get('company_owner/destroy/{id}', 'CompanyOwnerController@destroy');

//users
Route::resource('user', 'UserController');

Route::post('user/update', 'UserController@update')->name('user.update');

Route::get('user/destroy/{id}', 'UserController@destroy');


//project_worker
Route::resource('project_worker', 'ProjectWorkerController');

Route::post('project_worker/update', 'ProjectWorkerController@update')->name('project_worker.update');

Route::get('project_worker/destroy/{id}', 'ProjectWorkerController@destroy');
