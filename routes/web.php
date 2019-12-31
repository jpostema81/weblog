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

Route::get('/send-mail', function() {
    return new App\Mail\RegistrationConfirmation();

    Mail::to('newuser@example.com')->send(new App\Mail\RegistrationConfirmation()); 
    return 'A message has been sent to Mailtrap';
});

Route::get('/{any}', function() {
    return view('home');
})->where('any', '.*');

Route::resource('websockets', 'WebsocketsController');


