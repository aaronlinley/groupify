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

Route::middleware('auth:api')->group(function()
{
    Route::namespace('API')->group(function()
    {
        Route::prefix('users')->group(function()
        {
            Route::get('/{user}/get', 'UserController@get');
            Route::post('/{user}/update', 'UserController@update');
        });

        Route::prefix('playlists')->group(function()
        {
            Route::get('/{user}/get', 'PlaylistController@get');
        });
    });
});