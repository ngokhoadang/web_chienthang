<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('language', 'Api\LanguageController@index');
Route::get('pages', 'Api\PageController@index');
Route::get('permissions', 'Api\PermissionController@index');
Route::get('groups', 'Api\GroupController@index');
Route::get('layouts', 'Api\LayoutController@index');
Route::get('categories', 'Api\CategoryController@index');
Route::get('widgetcolumns', 'Api\WidgetColumnController@index');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
