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

Route::get('/', 'Home\HomeController@index')->name('root');



/**
 * Home前端用户界面相关的路由
 */
Route::group(['middleware' => 'auth','namespace' => 'Home'], function () {

    Route::get('updateLog', 'HomeController@updateLog')->name('updateLog');
    Route::get('getDesc', 'HomeController@getDesc')->name('getDesc');
});

/**
 * admin用户界面相关的路由
 */
Route::group(['middleware' => 'CheckAuth','namespace' => 'Admin'], function () {

    Route::any('/admin', 'DashboardController@index')->name('admin');
    Route::any('admin/feedback', 'FeedbackController@index');

    Route::any('admin/account', 'AccountVerifyController@index')/*->name('account')*/;
    Route::any('account/verify', 'AccountVerifyController@verify');

    Route::any('admin/columnSetting', 'ColumnSettingController@index')->name('columnSetting');

    Route::any('updateLog/index', 'updateLogController@index');
    Route::any('updateLog/add', 'updateLogController@store');
    Route::any('updateLog/create', 'updateLogController@create');
    Route::any('updateLog/show','updateLogController@show');
    Route::any('updateLog/update','updateLogController@update');

    Route::any('static/getNotesClass','DashboardController@getNotesClass');
    Route::any('static/getNumCount','DashboardController@getNumCount');
    Route::any('static/getNotesGrowth','DashboardController@getNotesGrowth');
    Route::any('static/getRankingList','DashboardController@getRankingList');

    Route::any('admin/users','UserController@index');

});


Auth::routes();

//分享相关
Route::any('share', 'ShareController@show');
Route::any('share/index', 'ShareController@index');
Route::any('share/add/{id}', 'ShareController@share');
Route::any('share/cancel/{id}', 'ShareController@cancel');

/**
 * 笔记相关的路由
 */
Route::group(['namespace' => 'Notes'], function () {

    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');


    // 文件夹相关的路由
    Route::any('/folder/add', 'FolderController@store');
    Route::post('/folder/del', 'FolderController@del');
    Route::post('/folder/update', 'FolderController@update');
    Route::get('/folder/list', 'FolderController@listAll');

    Route::get('/group/list', 'FolderController@getGroups');

    // 笔记相关路由
    Route::any('/note/index', 'NotesController@index');
    Route::any('/note/add', 'NotesController@add');
    Route::post('/note/del', 'NotesController@del');
    Route::post('/note/update', 'NotesController@update');
    Route::any('/note/find', 'NotesController@find');
    Route::any('/note/show', 'NotesController@show');
    Route::any('/note/latest', 'NotesController@latest');
    Route::any('/note/search', 'NotesController@search');
    Route::any('/note/recycle', 'NotesController@getRecycle');
    Route::any('/note/recovery', 'NotesController@recoveryNote');

    Route::any('/note/lockNote', 'NotesController@lockNote');
    Route::any('/note/unlockNote', 'NotesController@unlockNote');
    Route::any('/note/move', 'NotesController@move');


    // 用户操作相关路由
    Route::get('modify', 'UserController@getModify')->name('modify');
    Route::post('modify', 'UserController@postModify')->name('modify');

    Route::any('/forget', 'UserController@checkEmail')->name('forget');
    Route::post('/doForget', 'UserController@handleEmail')->name('doForget');

    Route::any('/reset', 'UserController@getForget')->name('reset');
    Route::post('/doReset', 'UserController@getForget')->name('doReset');

    Route::get('avatar', 'AvatarsController@index')->name('avatar');
    Route::post('avatar', 'AvatarsController@upload');
    Route::post('avatar/select', 'AvatarsController@selectAvatar');
    Route::post('avatar/del', 'AvatarsController@deleteAvatar');

});


/**
 * 资源请求或上传路由
 * 需要验证域名只有指定的域名才可以使用
 */
Route::group(['middleware' => 'CheckHost'/*,'domain' => '*.omwteam.com'*/], function () {

    // 公共路由
    Route::any('/common/mdEditorUpload', 'CommonController@mdEditorUpload');
    Route::any('/common/wangEditorUpload', 'CommonController@wangEditorUpload');
    Route::any('/common/upload', 'CommonController@upload');
    Route::any('/common/exportmd', 'CommonController@exportmd');



});


Route::any('/common/prompt', 'CommonController@prompt')->name('prompt');
Route::any('checkLogin', 'Notes\UserController@checkLogin')->name('checkLogin');
Route::any('/test', 'TestController@test');
Route::any('/feedback', 'Admin\FeedbackController@create')->name('feedback');
Route::any('/feedback/store', 'Admin\FeedbackController@store')->name('feedback.store');




