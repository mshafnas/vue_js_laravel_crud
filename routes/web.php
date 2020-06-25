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

// route for adding data
Route::post('/storeData', 'DataController@store');
// route for getting data
Route::get('/getData', 'DataController@getData');
// route for delete data
Route::post('deleteData/{id}', 'DataController@destroy');
// route for updating data
Route::post('editData/{id}', 'DataController@update');