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
		
		Route::get('security','SecurityController@securityMenu');
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
		Route::get('roles/{role}',function($role){
			return View::make('admin/abilities',['role' => $role]);
		});
		Route::get('security',function(){
			return view('admin/security');
		});
		Route::post('security','AdminController@saveEncryptionKey');
	});
	
	Route::get('admin/tactictypes', function(){
  		return view('admin/tactictypes');
	});
	Route::get('admin/tactictype/{id}', function($id){
		  return View::make('admin/tactic', ['tactictype_id' => $id]);
	});
	
	// Password Manager
	Route::group(['middleware' => 'passwordmanager'], function() {
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
	
	// Website list
	Route::group(['middleware' => 'websitelist'], function() {
		Route::get('/websites', function() {
			return view('websites/websites');
		});
	});
	
	// Milestones
	Route::get('/milestones', function() {
		return view('milestones/milestones');
	});
	
	// Forms
	Route::get('/forms', function() {
		return view('forms/view-forms');
	});
	Route::get('/forms/create', function() {
		return View::make('forms/create-form');
	});
	Route::get('/forms/edit/{id}', function($id) {
		return View::make('forms/edit-form', ['id' => $id]);
	});
	
	// Audit Forms (forms v2)
	Route::get('/auditforms', function() {
    	return view('audits/formlist');
	});
	
	Route::group(['prefix' => 'time'], function() {
  	Route::get('/', 'TimeReportController@time');
  	Route::get('report/{name}', function($name){
    	return view('time/report', ['name' => $name]);
    });
    
	});
});

Route::get('/forms/{id}', function($id) {
	return View::make('forms/form', ['id' => $id]);
});

Route::get('/form/{id}', function($id) {
    return View::make('audits/form', ['id' => $id]);
});

// RESTful resource routes
Route::group(['prefix' => 'api', 'middleware' => 'auth'], function() {
	Route::group(['middleware' => 'passwordmanager'], function() {
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
	Route::group(['middleware' => 'websitelist'], function(){
		Route::resource('website', 'WebsiteController', ['only' => ['index','store','update','destroy']]);
			Route::get('website/{website}/check', 'WebsiteController@check');
			Route::get('website/{website}/uncheck', 'WebsiteController@uncheck');
			Route::get('website/days', function() {
				return \App\Setting::getValue('website_check_days');
			});
	});
	Route::group(['middleware' => ['auth','admin']],function() {
		Route::get('ability/{role}','AbilityController@get');
		Route::post('ability/{role}','AbilityController@save');
	});
	Route::resource('tactic', 'TacticController', ['only' => ['index','store','update','destroy']]);
	Route::resource('tactictype', 'TacticTypeController', ['only' => ['index','store','update','destroy']]);
		Route::get('tactic/names', 'TacticController@indexNames');
		Route::get('tactic/{id}', 'TacticController@show')->where('id','[0-9]+');
		Route::get('tactic/{name}', 'TacticController@showByName')->where('name','[A-Za-z]+');
		Route::get('tactictype/{id}', 'TacticTypeController@show')->where('id','[0-9]+');
		Route::get('tactictype/{id}/tactic', 'TacticController@indexByTypeId')->where('id','[0-9]+');
		Route::get('tactictype/names', 'TacticTypeController@indexNames');
        
	Route::group(['prefix' => 'tw'], function() {
    	Route::resource('company', 'TeamworkCompanyController', ['only' => ['index', 'show']]);
    	Route::resource('project', 'TeamworkProjectController', ['only' => ['index', 'show']]);
    	Route::resource('milestone', 'TeamworkMilestoneController', ['only' => ['index', 'show', 'store']]);
    	
    	Route::get('project/{id}/people', 'TeamworkProjectController@getPeople');
    	
    	Route::get('project/{id}/roles', 'TeamworkProjectController@getRoles');
    	Route::resource('harvest', 'TWHarvestController', ['only' => ['index','store']]);
	});
	
	Route::group(['prefix' => 'harvest'], function() {
    	Route::get('client', 'HarvestController@getClients');
    	Route::get('project', 'HarvestController@getProjects');
    	Route::get('task', 'HarvestController@getTasks');
    	Route::get('daily', 'HarvestController@getDaily');
    	Route::post('/', 'HarvestController@newEntry');
    	
    	Route::resource('tw', 'TWHarvestController', ['only' => ['index','store']]);
	});
	
	Route::resource('form', 'FormController', ['only' => ['index','store','destroy']]);
	
	Route::resource('auditform', 'AuditFormController', ['only' => ['index', 'store', 'destroy']]);
	Route::get('auditform/{id}/frozen', 'AuditFormController@frozen');
	Route::put('auditform/{id}/freeze', 'AuditFormController@freeze');
	Route::put('auditform/{id}/unfreeze', 'AuditFormController@unfreeze');
	Route::get('auditform/{id}/duplicate', 'AuditFormController@duplicate');
	Route::get('auditform/{id}/fields/deleted', 'AuditFormController@indexDeletedFields');
	
	Route::post('auditform/{id}/field', 'AuditFormController@createField');
	Route::post('auditform/{id}/field/after/{after_id}', 'AuditFormController@createFieldAfter');
	
	Route::delete('auditform/field/{id}', 'AuditFormController@destroyField');
	Route::get('auditform/field/{id}/restore', 'AuditFormController@restoreField');
	
	Route::get('time/now', 'TimeReportController@now');
	Route::get('time/nextpp', 'TimeReportController@next_pay_period_day');
	Route::get('time/prevpp', 'TimeReportController@prev_pay_period_day');
	
});
Route::get('api/form/{id}', 'FormController@show');
Route::put('api/form/{id}', 'FormController@update');

Route::put('api/auditform/{id}', 'AuditFormController@update');
Route::put('api/auditform/field/{id}', 'AuditFormController@updateField');
Route::get('api/auditform/{id}', 'AuditFormController@show');
Route::get('api/auditform/{id}/fields', 'AuditFormController@indexFields');
Route::post('api/auditform/field/{id}/upload', 'AuditFormController@upload');

Route::group(['prefix' => 'webhook'], function() {
	
	Route::get('mailchimp','WebhookController@mailchimp_get');
	Route::post('mailchimp','WebhookController@mailchimp_put');
	Route::delete('mailchimp','WebhookController@mailchimp_delete');
	
	Route::get('zoho','WebhookController@zoho_get');
	Route::post('zoho','WebhookController@zoho_put');
	Route::delete('zoho', 'WebhookController@zoho_delete');
	
	Route::group(['prefix' => 'teamwork'], function() {
    	Route::post('timecreated', 'TeamworkWebhookController@time_created');
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