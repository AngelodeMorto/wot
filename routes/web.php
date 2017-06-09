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

Route::get('/', ['uses' => 'SiteController@index', 'as' => 'home']);
Route::get('/analiz', ['uses' => 'SiteController@analiz', 'as' => 'analiz']);
Route::get('/refresh', ['uses' => 'SiteController@refresh', 'as' => 'refresh']);
Route::match(['get', 'post'], '/change_similar', ['uses' => 'SiteController@change_similar', 'as' => 'change_similar']);

Route::group(['middleware' => ['auth', 'checkRole'], 'prefix' => 'admin'], function (){

    Route::get('/', function () {
        return view('layouts.admin');
    });

    Route::group(['prefix' => 'articles'], function (){
        Route::get('/', ['uses' => 'Admin\ArticleController@index', 'as' => 'Articles']);
        Route::match(['get','post'],'/create', ['uses' => 'Admin\ArticleController@create', 'as' => 'createArticle']);
        Route::match(['get','post'],'/edit/{article}', ['uses' => 'Admin\ArticleController@edit', 'as' => 'editArticle']);
        Route::delete('/delete', ['uses' => 'Admin\ArticleController@delete', 'as' => 'deleteArticle']);
    });

});

Auth::routes();

Route::get('/home', 'HomeController@index');
