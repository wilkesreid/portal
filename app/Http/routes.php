<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

get('/', function () {
    return view('home');
});

Route::group(['middleware' => 'auth'], function() {
	Route::get('/time', function() {
		return view('time');
	});
	Route::group(['prefix' => 'user', 'middleware' => 'auth'],function() {
		Route::get('settings',function() {
			return view('user/settings');
		});
		Route::post('settings','UserController@saveSettings');
	});
});

// Login
get('auth/login','Auth\AuthController@getLogin');
post('auth/login','Auth\AuthController@postLogin');
get('auth/logout','Auth\AuthController@getLogout');

// Register
get('auth/register','Auth\AuthController@getRegister');
post('auth/register','Auth\AuthController@postRegister');

Route::controllers([
   'password' => 'Auth\PasswordController',
]);