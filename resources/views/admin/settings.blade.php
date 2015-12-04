@extends('layouts.main')

@section('title')
Admin Settings
@stop

@section('body')
<h1>Admin Settings</h1>
<form class="form-horizontal col-lg-6" method="post" action="/admin/settings">
{!! csrf_field() !!}
<fieldset>
	<legend>Settings</legend>
	<div class="form-group">
		<label for="theme" class="col-lg-2 control-label">Guest Theme</label>
			<div class="col-lg-10">
			<select name="theme" class="form-control">
				{{
					$themes = App\Theme::orderBy('name','asc')->get()
				}}
				@foreach ($themes as $theme)
				<option {{ (App\Setting::getValue('guest_theme') == $theme->id) ? 'selected="selected"' : '' }} value="{{ $theme->id }}">{{ $theme->name }}</option>
				@endforeach
			</select>
			<div class="help-block">The theme seen by anyone not logged in.</div>
			<div class="help-block">Themes from <a href="https://bootswatch.com">bootswatch.com</a></div>
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