<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

    Route::get('/','Home\IndexController@index') ;
    Route::get('/cate/{cate_id}','Home\IndexController@cate') ;
    Route::get('/article/{art_id}','Home\IndexController@article') ;

//    Route::get('/test', 'IndexController@index');
    Route::any('admin/login',['as'=>'admin.login','uses'=>'Admin\LoginController@login']); //用户登录
    Route::get('admin/logout','Admin\LoginController@logout'); //用户退出
    Route::get('admin/code','Admin\LoginController@code'); //登录验证码


Route::group(['middleware' => ['web','admin.login'],'prefix'=>'admin','namespace'=>'Admin'], function() {
    Route::get('/','IndexController@index'); //后台欢迎页面
    Route::get('info','IndexController@info'); //后台欢迎页面主体部分
    Route::any('pass','IndexController@password');//后台页面修改密码
    Route::post('cate/changeorder','CategoryController@changeOrder');//后台页面修改密码

    Route::resource('category','CategoryController');//分类资源
    Route::resource('article','ArticleController');//文章

    Route::resource('links','LinksController');//友情链接
    Route::post('links/changeorder','LinksController@changeOrder');//后台页面修改链接

    Route::resource('navs','NavsController');//自定义导航
    Route::post('navs/changeorder','NavsController@changeOrder');//后台页面修改导航

    Route::get('config/putfile','ConfigController@putFile');//
    Route::resource('config','ConfigController');//系统配置项
    Route::post('config/changeorder','ConfigController@changeOrder');//后台页面修改配置项
    Route::post('config/changecontent','ConfigController@changeContent');//

    Route::any('upload','CommonController@upload');//上传文件
});

