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

Route::get('/', 'MessagesController@index')->name('home');

// register a resourceful route to the controller:
Route::resource('messages', 'MessagesController');

Route::resource('admin/messages', 'Admin\MessagesController', [
    'as' => 'admin'
]);

Route::resource('categories', 'CategoriesController');

Route::resource('admin/categories', 'Admin\CategoriesController', [
    'as' => 'admin'
]);

Auth::routes();

Route::post('comments/{message}', 'MessagesController@storeComment')->name('comments.store');

Route::resource('admin/users', 'Admin\UserController', [
    'as' => 'admin'
]);

Route::resource('admin/roles', 'Admin\RoleController', [
    'as' => 'admin'
]);

Route::resource('admin/permissions', 'Admin\PermissionController', [
    'as' => 'admin'
]);