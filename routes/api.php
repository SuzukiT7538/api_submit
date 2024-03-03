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

// Route::post('/users', 'App\Http\Controllers\ConduitController@register');

// Route::resource('/users', 'App\Http\Controllers\UserController');
// Route::post('/users', 'App\Http\Controllers\Auth\RegisterController@register');

Route::group([

    'middleware' => 'api',
    'prefix' => 'users'

], function ($router) {


    Route::get('/', 'App\Http\Controllers\UserController@show');
    Route::post('/', 'App\Http\Controllers\UserController@store');
    Route::post('login', 'App\Http\Controllers\AuthController@login');
    Route::post('logout', 'App\Http\Controllers\AuthController@logout');
    Route::post('refresh', 'App\Http\Controllers\AuthController@refresh');
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'user'
], function ($router) {
    Route::get('/', 'App\Http\Controllers\AuthController@me');
    Route::put('/', 'App\Http\Controllers\UserController@update');
});

Route::post('articles', 'App\Http\Controllers\ArticleController@store');

Route::group([
    'middleware' => 'api',
    'prefix' => 'articles'
], function ($router) {
    Route::get('/', 'App\Http\Controllers\ArticleController@showall');
    Route::get('/{slug}', 'App\Http\Controllers\ArticleController@showArticle');
    Route::put('/{slug}', 'App\Http\Controllers\ArticleController@update');
    Route::delete('/{slug}', 'App\Http\Controllers\ArticleController@delete');

});
