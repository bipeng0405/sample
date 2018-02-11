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
Route::get('/','StaticPagesController@home')->name('home');
Route::get('/help','StaticPagesController@help')->name('help');
Route::get('/about','StaticPagesController@about')->name('about');
Route::get('signup','UsersController@create')->name('signup');

// resource 方法将遵循 RESTful 架构为用户资源生成路由
// 该方法第一个参数为 资源名称，第二个参数为 控制器名称
Route::resource('users','UsersController');


// GET login 显示登录页面
// POST login  创建新会话（登录）
// DELETE logout  销毁会话（退出登录）
Route::get('login','SessionsController@create')->name('login');
Route::post('login','SessionsController@store')->name('login');
Route::delete('logout','SessionsController@destroy')->name('logout');
