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

Route::group(['middleware' => ['auth']], function() 
{
    Route::post('/test_jwt', function() 
    {
        echo "you are authorized!";
    })->name('api.register');

    Route::resource('admin/users', 'Admin\UserController', [
        'as' => 'admin'
    ]);
    
    Route::resource('admin/roles', 'Admin\RoleController', [
        'as' => 'admin'
    ]);
    
    Route::resource('admin/permissions', 'Admin\PermissionController', [
        'as' => 'admin'
    ]);

    Route::resource('admin/categories', 'Admin\CategoriesController', [
        'as' => 'admin'
    ]);
    
    Route::resource('admin/messages', 'Admin\MessagesController', [
        'as' => 'admin'
    ]);
});

// Authentication routes
Route::post('/register', 'Auth\Api\AuthController@register')->name('api.register');

Route::post('/login', 'Auth\Api\AuthController@login')->name('api.login');

Route::post('/logout', 'Auth\Api\AuthController@logout')->name('api.logout');

Route::post('/get_user_by_token', 'Auth\Api\AuthController@getUserByToken')->name('api.get_user_by_token');
//

//Route::get('/messages', 'MessagesController@index')->name('api.messages');

Route::resource('/messages', 'MessagesController');

Route::get('/categories', 'CategoriesController@index')->name('api.categories');

Route::post('comments/{message}', 'MessagesController@storeComment')->name('comments.store');

