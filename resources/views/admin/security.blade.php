@extends('layouts.main')

@section('title')
Admin Settings
@stop

@section('body')
<?php
$key = App\Setting::where('name','encryption_key')->first()->value;
$key_set = ($key != "");
$browser_key = Cookie::get('key');
$browser_key_set = ($browser_key != "");
$key_hash = \App\Setting::where('name','encryption_key')->first()->value;
$browser_key_valid = ($browser_key_set && \Hash::check($browser_key,$key_hash));

$action = (session()->has('key'));
$success = ($action && session('key') == "valid");
$invalid = ($action && session('key') == "invalid");
?>
<h1>Admin Security</h1>
<form class="form-horizontal col-lg-6" method="post" action="/admin/security">
{!! csrf_field() !!}
@if (!$key_set)
<div class="alert alert-warning">
	The encryption key has not yet been set. You will not be able to store passwords in the password manager until
	you set the encryption key to a random, 32 character string.
</div>
@else
<div class="alert alert-success">
	The password manager is set to work with an encryption key.
</div>
@endif
@if ($key_set && (!$browser_key_set || !$browser_key_valid))
<div class="alert alert-warning">
	<b>Warning:</b> You have not yet set the encryption key for this browser. You will not be able to change the encryption
	key for the password manager until this browser is using the correct, current encryption key.
</div>
@endif
<fieldset>
	<legend>Security</legend>
	<div class="form-group">
		<label for="theme" class="col-lg-2 control-label">Encryption Key</label>
			<div class="col-lg-10">
				@if ($action && $success)
				<div class="alert alert-success">
					The encryption key has been changed.
				</div>
				@elseif ($action && $invalid)
				<div class="alert alert-danger">
					The given key is not a valid AES-256-CBC key. The key should be 32 characters long and randomly
					generated.
				</div>
				@elseif ($action && !$success)
				<div class="alert alert-danger">
					Your browser key is not set correctly. You cannot change the encryption key without having the 
					correct existing one set in your browser.
				</div>
				@endif
			<input type="password" name="key" class="form-control"
			@if ($key_set && (!$browser_key_set || !$browser_key_valid))
			disabled
			@endif
			>
			</select>
			<div class="help-block">The encryption key for encrypting and decrypting credentials.</div>
		</div>
	</div>
	@if ($browser_key_set && $key_set && $browser_key_valid)
	<div class="form-group">
		<div class="col-lg-10 col-lg-offset-2">
			<div class="alert alert-warning">
				<b>Warning:</b> By changing this key, you will re-encrypt the entire database of credentials.
				This means you will have to re-enter this new key on every browser that needs access to the
				password portal.
			</div>
		</div>
	</div>
	@endif
	<div class="form-group">
		<div class="col-lg-10 col-lg-offset-2">
			<input type="submit" class="btn btn-primary" value="Save"
			@if ($key_set && (!$browser_key_set || !$browser_key_valid))
			disabled
			@endif
			>
		</div>
	</div>
</fieldset>
</form>
@stop