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

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/', 'EmployeesController@index')->name('dashboard');

Auth::routes();

//Route::get('/dashboard', 'EmployeesController@index')->name('dashboard');

// CRUD
# Create
Route::post('/employees/create', 'EmployeesController@addNode');
# Read (view)
Route::get('/employees/view/{id}', 'EmployeesController@viewNode');
Route::get('/employees/all', 'EmployeesController@viewAll'); // + pagination
# Update
Route::put('/employees/update', 'EmployeesController@updateNode');
# Delete
Route::delete('/employees/delete', 'EmployeesController@deleteNode');

// Lazy load
Route::post('/employees/get-branch', 'EmployeesController@getBranch');

// Upload file
Route::post('/employees/upload', 'EmployeesController@upload');

Route::get('/test', 'TestController@run');