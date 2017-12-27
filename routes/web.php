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
Route::get('/2', function () {
    return view('welcome2');
});

Auth::routes();

// Route::middleware(['auth'])->group(function () {

    Route::get('/home', 'HomeController@index')->name('home');

    // route model binding by hash. {match} : stands for the hash
    Route::get('/chat/{match}', 'MatchController@show');

    Route::post('/newChatMessage', 'MessageController@store');


// });
