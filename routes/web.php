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
    Route::get('/search', 'EmployeesController@search')->name('search');

    # EmployeesTransfer
    Route::get('/transfer', function() {
        return view('tree.tree-template');
    });
    Route::post('/get-first', function() {
        $m = new App\Employees();
        $m = $m->getTree(1);
       return response()->json($m);
    });
    Route::post('/move-node', 'EmployeesController@moveNode');

    # Images

//    Route::get('resizeImage', 'ImageController@resizeImage');
//    Route::post('resizeImagePost',['as'=>'resizeImagePost','uses'=>'ImageController@resizeImagePost']);
});