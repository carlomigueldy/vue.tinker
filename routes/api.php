<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// List the articles
Route::get('articles', 'ArticlesController@index');

// List a single article
Route::get('article/{id}', 'ArticlesController@show');

// Create new article
Route::post('article', 'ArticlesController@store');

// Update article
Route::put('article', 'ArticlesController@store');

// Delete article
Route::delete('article/{id}', 'ArticlesController@destroy');