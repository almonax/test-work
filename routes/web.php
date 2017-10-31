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

Auth::routes();


Route::group(['middleware' => 'auth'], function () {
    // Main page
    Route::get('/', function() {
        $employees = App\Employees::paginate(20);
        return view('dashboard', ['employees' => $employees]);
    });

    // CRUD
    # Read (views)
    Route::get('/view/{id}', 'EmployeesController@viewNode')->name('view');

    # Create
    Route::get('/create/{id?}', 'EmployeesController@create');
    Route::post('/create', 'EmployeesController@addNode');

    # Update
    Route::get('/edit/{id}', 'EmployeesController@edit');
    Route::put('/edit', 'EmployeesController@update');

    # Delete
    Route::delete('/delete', 'EmployeesController@delete');
    # Search
    Route::get('/search/{query}', 'EmployeesController@search')->name('search');
});

/**
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

 *
 *
 * function($id = null) {
$parentData = App\Employees::find($id)->get(['id', 'fullname']);
if ($id && preg_match('[0-9]+', $id))
$parentData = App\Employees::find($id)->get(['id', 'fullname']);
if (! $parentData) abort(404, 'Records with this id not found');

return view('cruds.create', ['parent' => ]);
 *
 * ============
function($id) {
$employee = App\Employees::find($id);
return view('cruds.edit', ['employee' => $employee]);
}
 */