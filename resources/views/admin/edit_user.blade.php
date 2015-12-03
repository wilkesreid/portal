@extends('layouts.main')

@section('title')
Edit User
@stop

<?php
	$user = App\User::find($user_id);
?>

@section('body')
<h1>{{ $user->name }}</h1>
<form class="form-horizontal col-lg-6" method="post" action="/admin/users/save">
{!! csrf_field() !!}
<input type="hidden" name="user_id" value="{{$user->id}}">
<fieldset>
	<legend>Edit User</legend>
	<div class="form-group">
		<label for="role" class="col-lg-2 control-label">Role</label>
		<div class="col-lg-10">
			
				@foreach (\App\Role::all() as $role)
				<input type="radio" name="role" value="{{$role->name}}" {{ ($role->name == $user->settings->role) ? 'checked="checked"' : ''}}> {{$role->name}}<br>
				@endforeach
			
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