@extends('layouts.main')

@section('title')
Tactic Settings
@stop

@section('body')
<?php
$tactictype = \App\TacticType::find($tactictype_id);
?>
<style>
    tr > td:first-child {
        width: 10%;
    }
</style>
<a class="btn btn-default" href="/admin/tactictypes"><span class="fa fa-arrow-left"></span> Back</a>
<h1>{{ $tactictype->name }}</h1>
<hr>
<div class="listtactics" ng-controller="TacticController as vm">
  <button type="button" class="btn btn-success" ng-click="vm.showCreateForm = !vm.showCreateForm" ng-show="!vm.showCreateForm">New Tactic</button>
<button type="button" class="btn btn-default" ng-click="vm.showCreateForm = !vm.showCreateForm" ng-show="vm.showCreateForm">Close</button>
<br><br>
<form class="form-horizontal col-lg-6" ng-show="vm.showCreateForm" ng-cloak>
{!! csrf_field() !!}
<fieldset>
	<legend>Create Tactic</legend>
	<div class="form-group">
		<label for="role" class="col-lg-3 control-label">Tactic Name</label>
		<div class="col-lg-9">
			<input type="text" name="name" class="form-control" ng-model="vm.newtacticName">
		</div>
	</div>
	<div class="form-group">
		<div class="col-lg-9 col-lg-offset-3">
			<button type="button" class="btn btn-primary" ng-click="vm.create()">Create</button>
		</div>
	</div>
</fieldset>
</form>
<div ng-show="vm.loading" style="text-align:center">
		<img src="/images/ajax-loader.svg">
	</div>
	<table ng-cloak class="table table-striped table-hover" ng-hide="vm.loading">
		<thead>
			<tr>
				<th>Actions</th>
				<th>Name</th>
			</tr>
		</thead>
		<tbody>
			<tr ng-repeat="tactic in vm.tactics">
				<td>
					<span style="cursor:pointer;font-size:1.3em" class="fa fa-times text-danger" ng-click="vm.delete(tactic)"></span>
					<span style="cursor:pointer;font-size:1.3em;margin-left:5px;" class="fa fa-pencil text-warning" ng-click="vm.edit(tactic)"></span>
				</td>
				<td>
    				<span ng-hide="tactic.editing">@{{tactic.name}}</span><input class="form-control" ng-show="tactic.editing" ng-model="tactic.name" style="min-width: 50%;width: auto;float: left;margin-right: 3px;">
                    <span ng-show="tactic.editing"><a ng-click="vm.save(tactic)" class="btn btn-success">Save</a> <a ng-click="vm.cancel(tactic)" class="btn btn-default">Cancel</a></span>
				</td>
			</tr>
		</tbody>
	</table>
</div>
<script>
  window.tactictype_id = {{ $tactictype_id }};
</script>
<script src="/js/angular/milestones/tacticFactory.js"></script>
<script src="/js/angular/admin/tactic/tacticController.js"></script>
<script src="/js/angular/admin/tactic/modals/deleteTactic.js"></script>
@stop