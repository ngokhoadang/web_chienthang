<?php

use Illuminate\Support\Facades\Route;

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

Route::get('login',['as'=>'user.login', 'uses'=>'Auth\LoginController@showLoginForm']);
Route::post('postlogin',['as'=>'user.postlogin', 'uses'=>'Auth\LoginController@checkLogin']);
Route::get('logout',['as'=>'user.logout', 'uses'=>'Auth\LoginController@logout']);
Route::get('admin', function () {
	return redirect('admin/index');
});
Route::group(['prefix'=>'admin','middleware'=>'auth'],function(){
    Route::get('index',['as'=>'admin.index','uses'=>'HomeController@adminIndex']);
    Route::post('loadmenu',['as'=>'admin..loadmenu','uses'=>'HomeController@loadAdminMenu']);
    Route::post('permissions',['as'=>'post.permissions', 'uses'=>'PermissionController@getPermission']);
    Route::group(['prefix'=>'permissiongroups'],function(){
        Route::post('json', ['as'=>'permissiongroups.json', 'uses'=>'PermissionController@jsonPermissionGroup']);
        Route::post('permission', ['as'=>'permissiongroups.permission', 'uses'=>'PermissionController@permissionList']); //List permission using set to group
        Route::get('config', ['as'=>'permissiongroups.config', 'uses'=>'PermissionController@configPermission']);
        Route::post('update', ['as'=>'permissiongroups.update', 'uses'=>'PermissionController@updatePermissionGroup']);
    });
    Route::group(['prefix'=>'uploads'],function(){
        Route::post('loadfolder/{folder_id}', ['as'=>'folder.load', 'uses'=>'DropzoneController@loadFolder']);
        Route::post('addfolder', ['as'=>'folder.post', 'uses'=>'DropzoneController@postFolder']);
        Route::post('uploadimage', ['as'=>'image.post', 'uses'=>'DropzoneController@postUpload']);
    });
    Route::group(['prefix'=>'editor'],function(){
        Route::get('loadckfinder',['as'=>'ckfinder','uses'=>'CKFinderController@loadckfinder']);
	    Route::any('ckconnect',['as'=>'ckconnect','uses'=>'CKFinderController@ckconnector']);
    });
    Route::group(['prefix'=>'widget'],function(){
        Route::post('json', ['as'=>'post.json', 'uses'=>'WidgetController@postJson']); //Get layout detail
        Route::post('update', ['as'=>'post.create', 'uses'=>'WidgetController@postUpdate']);
        Route::post('update/{id}', ['as'=>'post.create', 'uses'=>'WidgetController@loadUpdateInfo']);
        Route::post('remove',['as'=>'post.remove',      'uses'=>'WidgetController@postRemove']);
    });
    Route::group(['prefix'=>'layouts'],function(){
        Route::post('json', ['as'=>'post.json', 'uses'=>'LayoutController@postJson']); //Get layout detail
        Route::post('create', ['as'=>'post.create', 'uses'=>'LayoutController@postCreate']);
        Route::post('load-data-update', ['as'=>'post.data.update', 'uses'=>'LayoutController@getDataUpdate']);
    });
    Route::group(['prefix'=>'layoutconfigs'],function(){
        Route::get('list', ['as'=>'get.list', 'uses'=>'LayoutController@getList']); //Cập nhật hiển thị giao diện website
        Route::get('setting', ['as'=>'get.setting', 'uses'=>'LayoutController@getHeader']); //Cập nhật hiển thị giao diện website
        Route::post('update', ['as'=>'post.update', 'uses'=>'LayoutController@layoutConfigUpdate']); //Cập nhật hiển thị giao diện website
    });
    Route::group(['prefix'=>'moduleconfig'],function(){
        Route::post('json', ['as'=>'post.json', 'uses'=>'ModuleConfigController@getJson']);
        Route::post('create', ['as'=>'post.create', 'uses'=>'ModuleConfigController@postCreate']);
        Route::post('update/{id}',['as'=>'load.data.update', 'uses'=>'ModuleConfigController@loadDataUpdate']);
    });
    Route::group(['prefix'=>'groups'],function(){
        Route::post('create', ['as'=>'post.create', 'uses'=>'GroupController@postCreate']);
        Route::get('update/{id}',['as'=>'get.create', 'uses'=>'GroupController@getUpdate']);
    });
    Route::group(['prefix'=>'users'],function(){
        Route::post('create',['as'=>'post.create', 'uses'=>'UserController@postCreate']);
        Route::get('update/{id}',['as'=>'get.create', 'uses'=>'UserController@getUpdate']);
    });
    Route::group(['prefix'=>'pages'],function(){
        Route::get('json',['as'=>'json',                'uses'=>'PagesController@getJon']);
        Route::post('post-create',['as'=>'post.create', 'uses'=>'PagesController@postCreate']);
    });
    Route::group(['prefix'=>'fields'],function(){
        Route::post('json',['as'=>'get.json',            'uses'=>'FieldController@getJson']); //Load data field JSON
        Route::post('info',['as'=>'get.info',            'uses'=>'FieldController@getInfo']);
        Route::post('create',['as'=>'post.create',      'uses'=>'FieldController@postUpdate']);
        Route::post('update',['as'=>'post.update',      'uses'=>'FieldController@postUpdate']);
    });
    Route::group(['prefix'=>'articles'],function(){
        Route::get('list-json',['as'=>'json.list',      'uses'=>'ArticleController@listJson']);
        Route::post('create',['as'=>'post.create',      'uses'=>'ArticleController@postUpdate']);
        Route::post('update',['as'=>'post.update',      'uses'=>'ArticleController@postUpdate']);
    });
    //
    Route::group(['prefix'=>'contents'],function(){
        Route::post('create',['as'=>'post.create',      'uses'=>'ContentController@postUpdate']);
        Route::post('update',['as'=>'post.update',      'uses'=>'ContentController@postUpdate']);
    });
    /**
     * WEBSITE STYLE
     * -- Cho phép thành viên được cài phân quyền có thể chỉnh sửa file css và upload lên website
     */
    Route::group(['prefix'=>'webstyles'],function(){
        Route::get('config',['as'=>'get.create',        'uses'=>'WebsiteStyleController@getConfig']);
        Route::post('post',['as'=>'post.post',        'uses'=>'WebsiteStyleController@postStyles']);
    });
    Route::group(['prefix'=>'{module}'],function(){
        Route::post('list-json',['as'=>'json.list',      'uses'=>'ModuleProcessController@listJson']);
        Route::get('list',['as'=>'get.list',            'uses'=>'ModuleProcessController@getList']);
        Route::get('create',['as'=>'get.create',        'uses'=>'ModuleProcessController@getCreate']);
        Route::post('create',['as'=>'post.create',      'uses'=>'ModuleProcessController@postUpdate']);
        Route::get('update/{id}',['as'=>'get.update',   'uses'=>'ModuleProcessController@getUpdate']);
        Route::post('update-json',['as'=>'update.json',   'uses'=>'ModuleProcessController@loadUpdateInfo']);
        Route::post('update',['as'=>'post.update',      'uses'=>'ModuleProcessController@postUpdate']);
        Route::post('remove',['as'=>'post.remove',      'uses'=>'ModuleProcessController@postRemove']);
    });
});

Auth::routes();

Route::get('/', ['as'=>'index','uses'=>'HomeController@index']);
Route::get('/tim-kiem.html', ['as'=>'index.list','uses'=>'HomeController@search']);
// ---dang----
Route::get('/lien-he/{id}', ['as'=>'index.list','uses'=>'HomeController@contactPage']);
Route::post('/lien-he/{id}/save', ['as'=>'index.list','uses'=>'HomeController@saveContactPage']);
Route::post('/loadwidget-index', ['as'=>'index.list','uses'=>'HomeController@loadWidgetIndex']);
Route::get('/lien-he', ['as'=>'index.list','uses'=>'HomeController@contactPage']);
// -----------
Route::get('/{alias}', ['as'=>'index.list','uses'=>'HomeController@contentList']);
Route::get('/{alias}/{id}', ['as'=>'index.detail','uses'=>'HomeController@contentDetail']);
Route::group(['prefix'=>'editor'],function(){
    Route::get('loadckfinder',['as'=>'ckfinder','uses'=>'CKFinderController@loadckfinder']);
    Route::any('ckconnect',['as'=>'ckconnect','uses'=>'CKFinderController@ckconnector']);
});

