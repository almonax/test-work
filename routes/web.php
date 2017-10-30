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
//    return views('welcome');
//});

//Route::get('/', 'EmployeesController@index')->name('dashboard');

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/', function() {
        $employees = App\Employees::paginate(20);
        return view('dashboard', ['employees' => $employees]);
    });

    // CRUD
    # Read (views)
    Route::get('/views/{id}', 'EmployeesController@viewNode')->where('id', '[0-9]+');
});


Auth::routes();

Route::post('/get-begin-tree', 'EmployeesController@getBeginTree');

// CRUD
# Create
Route::post('/employees/create', 'EmployeesController@addNode');


Route::get('/employees/all', 'EmployeesController@viewAll'); // + pagination
# Update
Route::put('/employees/update', 'EmployeesController@updateNode');
# Delete
Route::delete('/employees/delete', 'EmployeesController@deleteNode');

// Lazy load
Route::post('/employees/get-branch', 'EmployeesController@getBranch');

// Upload file
Route::post('/employees/upload', 'EmployeesController@upload');

Route::get('/transfer', 'EmployeesController@transfer');

Route::get('/test', 'TestController@run');