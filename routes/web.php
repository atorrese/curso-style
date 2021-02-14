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
    return 'Home';
});

Route::get('/usuarios', 'UserController@index')->name('users.index');

Route::get('/usuarios/{user}', 'UserController@show')
    ->where('user','[0-9]+')
    ->name('users.show');

Route::get('/usuarios/nuevo', 'UserController@create')->name('users.create');

Route::get('/usuarios/{user}/edit', 'UserController@edit')
    ->where('user','[0-9]+')->name('users.edit');

Route::post('/usuarios','UserController@store');

Route::put('/usuarios/{user}', 'UserController@update')
    ->where('user','[0-9]+')
    ->name('users.update');

Route::delete('/usuarios/{user}', 'UserController@destroy')
    ->where('user','[0-9]+')
    ->name('users.destroy');

Route::get('/saludo/{name}/', 'WelcomeUsersController@without_nickname');
Route::get('/saludo/{name}/{nickname?}', 'WelcomeUsersController');


