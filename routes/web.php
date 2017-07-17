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
})->name('root');

Route::get('getReadme', function () {
    return file_get_contents(base_path().'/README.md');
})->name('getReadme');





/**
 * 问题反馈相关
 */
Route::any('/feedback', 'FeedbackController@create')->name('feedback');
Route::any('/feedback/store', 'FeedbackController@store')->name('feedback.store');
Route::any('/admin', 'FeedbackController@index');


/**
 * 公共路由
 */
Route::any('/home', 'HomeController@index')->name('home');
Route::any('/common/mdEditorUpload', 'CommonController@mdEditorUpload');
Route::any('/common/wangEditorUpload', 'CommonController@wangEditorUpload');
Route::any('/common/upload', 'CommonController@upload');
Route::any('/common/checkLogin', 'CommonController@checkLogin');
Route::any('/common/prompt', 'CommonController@prompt')->name('prompt');

/**
 * 测试路由
 */
Route::any('/test', 'TestController@test');



Auth::routes();

Route::any('/forget', 'UserController@checkEmail')->name('forget');
Route::post('/doForget', 'UserController@handleEmail')->name('doForget');

Route::any('/reset', 'UserController@getForget')->name('reset');
Route::post('/doReset', 'UserController@getForget')->name('doReset');

/**
 * 需权限认证的路由
 */
Route::group(['middleware' => 'auth'], function () {

    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    Route::get('/myshare', 'DashboardController@share')->name('myshare');

    Route::post('/folder/add', 'FolderController@store');
    Route::post('/folder/del', 'FolderController@del');
    Route::post('/folder/update', 'FolderController@update');
    Route::get('/folder/list', 'FolderController@listAll');

    Route::any('/note/index', 'NotesController@index');
    Route::post('/note/add', 'NotesController@add');
    Route::post('/note/del', 'NotesController@del');
    Route::post('/note/update', 'NotesController@update');
    Route::any('/note/find', 'NotesController@find');
    Route::any('/note/show', 'NotesController@show');
    Route::any('/note/latest', 'NotesController@latest');
    Route::any('/note/search', 'NotesController@search');

    Route::get('modify', 'UserController@getModify')->name('modify');
    Route::post('modify', 'UserController@postModify');
});