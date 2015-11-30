@extends('layouts.main')

@section('title')
Register
@stop

@section('body')
<form class="form-horizontal col-lg-6" method="post" action="/auth/register">
{!! csrf_field() !!}
<fieldset>
	<legend>Register</legend>
	<div class="form-group">
		<label for="name" class="col-lg-2 control-label">Name</label>
		<div class="col-lg-10">
			<input type="text" class="form-control" name="name">
		</div>
	</div>
	<div class="form-group">
		<label for="email" class="col-lg-2 control-label">Email</label>
		<div class="col-lg-10">
			<input type="email" class="form-control" name="email">
		</div>
	</div>
	<div class="form-group">
		<label for="password" class="col-lg-2 control-label">Password</label>
		<div class="col-lg-10">
			<input type="password" class="form-control" name="password">
		</div>
	</div>
	<div class="form-group">
		<label for="password_confirmation" class="col-lg-2 control-label">Confirm Password</label>
		<div class="col-lg-10">
			<input type="password" class="form-control" name="password_confirmation">
		</div>
	</div>
	<div class="form-group">
		<div class="col-lg-10 col-lg-offset-2">
			<button type="submit" class="btn btn-primary">Register</button>
		</div>
	</div>
</fieldset>
</form>
@stop