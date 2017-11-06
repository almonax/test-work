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
    // Main page with pagination
    Route::get('/', function() {
        $employees = App\Employees::paginate(20);
        return view('dashboard', ['employees' => $employees]);
    });

    # CRUD
    // Get view profile of employee
    Route::get('/view/{id}', 'EmployeesController@viewNode')->name('view');

    # Create
    // Get form for create node
    Route::get('/create/{id?}', 'EmployeesController@create');
    // Create new node with input properties
    Route::post('/create', 'EmployeesController@addNode');

    # Update
    // Get update form
    Route::get('/edit/{id}', 'EmployeesController@edit');
    // Set new properties and save node
    Route::put('/edit', 'EmployeesController@update');

    # Delete
    // Delete node or branch
    Route::delete('/delete', 'EmployeesController@delete');

    # Search
    // Search by `id` or `fullname`
    Route::get('/search', 'EmployeesController@search')->name('search');

    # EmployeesTransfer
    // View profile employee
    Route::get('/transfer', function() {
        return view('tree.tree-template');
    });
    // Get two level when initialisation tree
    Route::post('/get-first', function() {
        $m = new App\Employees();
        $m = $m->getTree(1);
       return response()->json($m);
    });
    // Get branch-descendant of current node
    Route::get('/get-next-branch', 'EmployeesController@getBranch');
    // Save changes of transfer
    Route::post('/move-node', 'EmployeesController@moveNode');

    # Images
    // Ajax delete
    Route::post('/employee_delPhoto', 'EmployeesController@deleteEmployeePhoto');
});