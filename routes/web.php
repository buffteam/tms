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

Route::get('check', 'Tms\UsersController@check');
Route::resource('test', 'TestController');
Route::get('getAll', 'TestController@getAll');


/**
 * 用户表相关
 */


Route::group([/*'middleware' => 'auth',*/'namespace' => 'Tms'], function () {

    Route::get('register', 'RegisterController@register');
    Route::post('doRegister', 'RegisterController@doRegister');

    Route::get('login', 'LoginController@index')->name('login');
    Route::post('doLogin', 'LoginController@login');

    Route::get('/dashboard', 'HomeController@index')->name('dashboard');

    Route::resource('folder', 'FolderController');

    Route::post('/folder/add', 'FolderController@add');
    Route::post('/folder/del', 'FolderController@del');
    Route::post('/folder/update', 'FolderController@update');
    Route::get('/folder/find', 'FolderController@find');
    Route::get('/folder/list', 'FolderController@listAll');

    Route::post('/note/add', 'NotesController@add');
    Route::post('/note/del', 'NotesController@del');
    Route::post('/note/update', 'NotesController@update');
    Route::get('/note/find', 'NotesController@find');
    Route::get('/note/list', 'NotesController@listAll');
});
