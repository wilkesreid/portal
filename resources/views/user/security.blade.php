@extends('layouts.main')

@section('title')
User Settings
@stop

@section('body')
<?php
$key = \Cookie::get('key');
$key_hash = \App\Setting::where('name','encryption_key')->first()->value;
$key_set = ($key != "");
$key_correct = (\Hash::check($key,$key_hash));

$action = (session()->has('key'));
$success = ($action && session('key') == "valid");
?>
<h1>Security</h1>
<form class="form-horizontal col-lg-6" method="post" action="/user/security">
{!! csrf_field() !!}
@if (!$key_set)
<div class="alert alert-warning">
	You do not have an encryption key set on this browser. You won't be able to access the credentials in 
	the password manager until you provide the same encryption key set by the administrator.
</div>
@elseif (!$key_correct)
<div class="alert alert-warning">
	Your encryption key is not the same as the one set by the administrator. The administrator has probably changed
	the encryption key since the last time you set it in this browser.
</div>
@else
<div class="alert alert-success">
	You have a valid encryption key set for this browser. 
</div>
@endif
<fieldset>
	<legend>Security</legend>
	<div class="form-group">
		@if ($action && !$success)
		<div class="alert alert-danger">
			That isn't the current encryption key.
		</div>
		@elseif ($action && $success)
		<div class="alert alert-success">
			The key has been successfully set for this browser.
		</div>
		@endif
		<label for="theme" class="col-lg-2 control-label">Encryption Key</label>
		<div class="col-lg-10">
			<input type="password" name="key" class="form-control">
			<div class="help-block">If you are using a new browser, the encryption key must be given here.</div>
		</div>
	</div>
	<div class="form-group">
		<div class="col-lg-10 col-lg-offset-2">
			<input type="submit" class="btn btn-primary" value="Save">
		</div>
	</div>
</fieldset>
</form>
@stop