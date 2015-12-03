@extends('layouts.main')

@section('title')
User Settings
@stop

@section('body')
<h1>User Settings</h1>
<form class="form-horizontal col-lg-6" method="post" action="/user/settings">
{!! csrf_field() !!}
<fieldset>
	<legend>Settings</legend>
	<div class="form-group">
		<label for="theme" class="col-lg-2 control-label">Theme</label>
		<div class="col-lg-10">
			<select name="theme" class="form-control">
				{{
					$themes = App\Theme::orderBy('name','asc')->get()
				}}
				@foreach ($themes as $theme)
				<option {{ (Auth::user()->settings->theme == $theme->id) ? 'selected="selected"' : '' }} value="{{ $theme->id }}">{{ $theme->name }}</option>
				@endforeach
			</select>
			<span class="help-block">The theme you see when logged in.</span>
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