@extends('layouts.main')

@section('title')
Admin Settings
@stop

@section('body')
<a class="btn btn-default" href="/admin/roles"><span class="fa fa-arrow-left"></span> Back</a>
<h1>{{ ucwords($role) }}</h1>
<div class="listRoles" ng-controller="AbilityController as ctrl">
	
<form class="form-horizontal col-lg-6" ng-show="ctrl.showForm" ng-cloak>
{!! csrf_field() !!}
<fieldset>
	<legend>Abilities</legend>
	<div class="alert alert-success" ng-show="ctrl.savedSuccess">
	  <strong>Success</strong> The role has been saved.
	</div>
	<div class="form-group">
		<div class="col-lg-10">
			<label style="display:block" ng-repeat="ability in ctrl.allAbilities">
			<input type="checkbox" checklist-model="ctrl.abilities" checklist-value="ability"> @{{ ability }}
			</label>
		</div>
	</div>
	<div class="form-group">
		<div class="col-lg-10">
			<button type="button" class="btn btn-primary" ng-click="ctrl.save()">Save</button>
		</div>
	</div>
</fieldset>
</form>
</div>
<script>
	window.role = "{{$role}}";
</script>
<script src="/js/angular/admin/ability/abilityFactory.js"></script>
<script src="/js/angular/admin/ability/abilityController.js"></script>
@stop