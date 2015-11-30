@extends('layouts.main')

@section('title')
Login
@stop

@section('body')
<form class="form-horizontal col-lg-6" method="post" action="/auth/login">
{!! csrf_field() !!}
<fieldset>
	<legend>Login</legend>
	<div class="form-group">
		<label for="email" class="col-lg-2 control-label">Email</label>
		<div class="col-lg-10">
			<input type="email" class="form-control" name="email" value="{{ old('email') }}">
		</div>
	</div>
	<div class="form-group">
		<label for="password" class="col-lg-2 control-label">Password</label>
		<div class="col-lg-10">
			<input type="password" class="form-control" name="password">
		</div>
	</div>
	<div class="form-group">
		<div class="col-lg-10 col-lg-offset-2">
			<input class="btn btn-primary" type="submit" value="Login">
		</div>
	</div>
	<a class="col-lg-offset-2" href="/auth/register">Register</a>
</fieldset>
</form>
@stop