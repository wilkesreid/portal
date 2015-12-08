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

// For logged in users only
Route::group(['middleware' => 'auth'], function() {
	
	// User Settings (for own account)
	Route::group(['prefix' => 'user', 'middleware' => 'auth'],function() {
		Route::get('settings',function() {
			return view('user/settings');
		});
		Route::post('settings','UserController@saveSettings');
		Route::get('security',function(){
			return view('user/security');
		});
		Route::post('security','UserController@setEncryptionKey');
	});
	
	// Admin
	Route::group(['prefix' => 'admin', 'middleware' => ['auth','admin']],function(){
		Route::get('settings',function(){
			return view('admin/settings');
		});
		Route::post('settings','AdminController@saveSettings');
		
		Route::get('users',function(){
			return view('admin/users');
		});
		
		Route::get('users/{id}',function($id){
			return View::make('admin/edit_user',[ 'user_id' => $id ]);
		});
		Route::post('users/save','AdminController@saveUser');
		Route::get('users/delete/{id}','AdminController@deleteUser');
		Route::get('roles', function() {
			return view('admin/roles');
		});
		Route::get('security',function(){
			return view('admin/security');
		});
		Route::post('security','AdminController@saveEncryptionKey');
	});
	
	// Password Manager
	Route::group(['middleware' => 'pending'], function() {
		Route::get('/clients', function() {
			return view('passwords/home');
		});
		Route::get('/clients/{id}', ['as' => 'platforms', function($id) {
			return View::make('passwords/client', [ 'client_id' => $id ]);
		}]);
		Route::get('/platforms/{id}', ['as' => 'credentials', function($id){
			return View::make('passwords/platform', ['platform_id' => $id]);
		}]);
	});
});

// RESTful resource routes
Route::group(['prefix' => 'api', 'middleware' => 'auth'], function() {
	Route::resource('client', 'ClientController', ['only' => ['index','store','update','destroy']]);
	Route::resource('role', 'RoleController', ['only' => ['index','store','update','destroy']]);
	Route::resource('client.platform', 'PlatformController', ['only' => ['index','store','update','destroy']]);
		Route::get('platform/search/{name}','PlatformController@search');
		Route::get('platform/{name}','PlatformController@indexByName');
	Route::resource('credential', 'CredentialController', ['only' => ['index','update','destroy']]);
		Route::post('platform/{platform}/credential', 'CredentialController@store');
		Route::get('platform/{platform}/credential', 'CredentialController@indexOfPlatform');
		Route::get('platform/{platform}/credential/trash', 'CredentialController@indexTrashedOfPlatform');
		Route::get('credential/{credential}/restore', 'CredentialController@restore');
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