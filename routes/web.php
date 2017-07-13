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
//    $readme = file_get_contents(base_path().'\README.md');
    return view('welcome');
})->name('root');
Route::get('/getReadme', function () {
    return file_get_contents(base_path().'/README.md');
});
Auth::routes();

Route::any('/home', 'HomeController@index')->name('home');
Route::any('/common/mdEditorUpload', 'CommonController@mdEditorUpload');
Route::any('/common/wangEditorUpload', 'CommonController@wangEditorUpload');
Route::any('/common/checkLogin', 'CommonController@checkLogin');

/**
 * 问题反馈相关
 */
Route::any('/feedback', 'FeedbackController@create')->name('feedback');
Route::any('/feedback/store', 'FeedbackController@store')->name('feedback.store');
Route::any('/admin', 'FeedbackController@index');




Route::any('/test/export', 'CommonController@export')->name('export');

Route::any('/test', 'TestController@test');

Route::group(['middleware' => 'auth'], function () {

    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    Route::get('/myshare', 'DashboardController@share')->name('myshare');

    Route::any('/folder/add', 'FolderController@store');
    Route::any('/folder/del', 'FolderController@del');
    Route::any('/folder/update', 'FolderController@update');
    Route::get('/folder/list', 'FolderController@listAll');

    Route::any('/note/index', 'NotesController@index');
    Route::any('/note/add', 'NotesController@add');
    Route::any('/note/del', 'NotesController@del');
    Route::any('/note/update', 'NotesController@update');
    Route::any('/note/find', 'NotesController@find');
    Route::any('/note/show', 'NotesController@show');
    Route::any('/note/latest', 'NotesController@latest');
    Route::any('/note/search', 'NotesController@search');
});