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
    return redirect('/users-list');
});

/**
 * To users's list
 */
Route::get('/users-list', 'ListUsersController@list');

Route::post('/register/create', 'UserController@create');
Route::get('/register', function () {
    return view('users.register');
});

Route::get('/edit_user/{user}', 'UserController@getUser');
Route::post('/edit_user/edit', 'UserController@edit');

Route::get('users-list/delete/{user}', 'UserController@delete');