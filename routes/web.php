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
    return view('welcome2');
});
Route::get('/2', function () {
    return view('welcome2');
});
Route::get('/t', function () {
    return 'teeeee';
});

Auth::routes();

// Route::middleware(['auth'])->group(function () {

    Route::get('/pair', 'UserController@pair');

    Route::get('/user/profile', 'UserController@profile');
    Route::post('/user/profile', 'UserController@editProfile');

    Route::get('/home', 'HomeController@index')->name('home');

    // route model binding by hash. {match} : stands for the hash
    Route::get('/chat/{match}', 'MatchController@show')->name('chat');

    Route::post('/message/new', 'MessageController@store');
    Route::post('/invitation/new', 'InvitationController@store');
    Route::post('/invitation/calculate', 'InvitationController@calculate');
    Route::post('/invitation/approve', 'InvitationController@approve');
    Route::get('/invitation/list', 'InvitationController@index');

    // AJAX load matches
    Route::get('/match/all', 'MatchController@index');
    Route::post('/match/create', 'MatchController@store');

    // AJAX, after click on a match
    Route::get('/match/{match}/messages', 'MessageController@index');

    Route::post('/match/{match}/rate', 'MatchController@update');

// });
