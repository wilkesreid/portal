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
		<label for="theme" class="col-lg-3 control-label">Guest Theme</label>
			<div class="col-lg-9">
			<select name="theme" class="form-control">
				{{
					$themes = App\Theme::orderBy('name','asc')->get()
				}}
				@foreach ($themes as $theme)
				<option {{ (App\Setting::getValue('guest_theme') == $theme->id) ? 'selected="selected"' : '' }} value="{{ $theme->id }}">{{ $theme->name }}</option>
				@endforeach
			</select>
			<div class="help-block">The theme seen by anyone not logged in.</div>
			<div class="help-block">Themes from <a target="_blank" href="https://bootswatch.com">bootswatch.com</a></div>
		</div>
	</div>
	<div class="form-group">
		<label for="website_check_days" class="col-lg-3 control-label">Days Until Website Needs Checking</label>
		<div class="col-lg-9">
			<input type="number" class="form-control" name="website_check_days" value="{{ \App\Setting::getValue('website_check_days') }}">
			<div class="help-block">The number of days after marking a website as checked until the site needs checking again (for Websites).</div>
		</div>
	</div>
	<div class="form-group">
    	<label for="pay_period_one" class="col-lg-3 control-label">Pay Period Day-Of-Month: 1</label>
    	<div class="col-lg-9">
        	<input type="number" class="form-control" name="pay_period_one" value="{{ \App\Setting::getValue('pay_period_one') }}">
        	<div class="help-block">The first pay-period day of the month (for Time).</div>
    	</div>
	</div>
	<div class="form-group">
    	<label for="pay_period_one" class="col-lg-3 control-label">Pay Period Day-Of-Month: 2</label>
    	<div class="col-lg-9">
        	<input type="number" class="form-control" name="pay_period_two" value="{{ \App\Setting::getValue('pay_period_two') }}">
        	<div class="help-block">The second pay-period day of the month (for Time).</div>
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