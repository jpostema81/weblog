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

// test onderstaande route door een GET request te doen naar:
// http://localhost:8000/api/user?api_token=<token>
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', 'Auth\Api\LoginController@login')->name('api.login');

Route::resource('admin/categories', 'Admin\CategoriesController', [
    'as' => 'admin'
]);

Route::get('/messages', 'MessagesController@getMessages')->name('api.messages');

Route::get('/categories', 'CategoriesController@getCategories')->name('api.categories');

