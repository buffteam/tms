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
})->name('home');

Route::get('check', 'Tms\UsersController@check');
Route::resource('test', 'TestController');
Route::get('getAll', 'TestController@getAll');


/**
 * 用户表相关
 */

Route::any('upload', 'UtilController@upload');


Route::group(['namespace' => 'Tms'], function () {
    //
    Route::get('register', 'RegisterController@register')->name('register');
    Route::post('doRegister', 'RegisterController@doRegister');
    Route::get('login', 'LoginController@index')->name('login');
    Route::post('doLogin', 'LoginController@login');
    Route::any('logout', 'UsersController@logout')->name('logout');
    Route::any('/notes/upload', 'NotesController@upload');

});
Route::group(['middleware' => 'checkIsLogin','namespace' => 'Tms'], function () {

    Route::get('/dashboard', 'HomeController@index')->name('dashboard');


    Route::any('/folder/add', 'FolderController@store');
    Route::any('/folder/del', 'FolderController@del');
    Route::any('/folder/update', 'FolderController@update');
//    Route::get('/folder/find', 'FolderController@find');
    Route::get('/folder/list', 'FolderController@listAll');

    Route::any('/note/add', 'NotesController@add');
    Route::any('/note/del', 'NotesController@del');
    Route::any('/note/update', 'NotesController@update');
    Route::any('/note/find', 'NotesController@find');
    Route::any('/note/show', 'NotesController@show');
    Route::any('/note/list', 'NotesController@listAll');
});
