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
    if ( \Illuminate\Support\Facades\Auth::guest() )
        return view('welcome');

    return redirect()->route('home');
});

Auth::routes();

Route::get('login/spotify', 'Auth\LoginController@redirectToProvider')->name('login.spotify');
Route::get('login/spotify/callback', 'Auth\LoginController@handleProviderCallback');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/profile', 'UserController@profile')->name('profile');