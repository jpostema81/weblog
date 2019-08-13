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

Route::get('/', 'BlogPostsController@index')->name('home');

// register a resourceful route to the controller:
Route::resource('blogposts', 'BlogPostsController');

// apply same middleware to multiple routes by grouping routes
Route::middleware(['first', 'second'])->group(function () {
    Route::get('/', function () {
        // Uses first & second Middleware
    });
});

Route::resource('admin/blogposts', 'Admin\BlogPostsController');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
