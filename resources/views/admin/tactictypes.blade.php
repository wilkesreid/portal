@extends('layouts.main')

@section('title')
Tactic Settings
@stop

@section('body')
<style>
    tr > td:first-child {
        width: 10%;
    }
</style>
<h1>Tactic Types</h1>
<hr>
<div class="listTacticTypes" ng-controller="TacticTypeController as vm">
  <button type="button" class="btn btn-success" ng-click="vm.showCreateForm = !vm.showCreateForm" ng-show="!vm.showCreateForm">New Tactic Type</button>
<button type="button" class="btn btn-default" ng-click="vm.showCreateForm = !vm.showCreateForm" ng-show="vm.showCreateForm">Close</button>
<br><br>
<form class="form-horizontal col-lg-6" ng-show="vm.showCreateForm" ng-cloak>
{!! csrf_field() !!}
<fieldset>
	<legend>Create Tactic Type</legend>
	<div class="form-group">
		<label for="role" class="col-lg-4 control-label">Tactic Type Name</label>
		<div class="col-lg-8">
			<input type="text" name="name" class="form-control" ng-model="vm.newTacticTypeName">
		</div>
	</div>
	<div class="form-group">
		<div class="col-lg-8 col-lg-offset-4">
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
			<tr ng-repeat="tactictype in vm.TacticTypes">
				<td>
					<span style="cursor:pointer;font-size:1.3em" class="fa fa-times text-danger" ng-click="vm.delete(tactictype)"></span>
					<span style="cursor:pointer;font-size:1.3em;margin-left:5px;" class="fa fa-pencil text-warning" ng-click="vm.edit(tactictype)"></span>
				</td>
				<td>
    				<a href="/admin/tactictype/@{{tactictype.id}}" ng-hide="tactictype.editing">@{{tactictype.name}}</a><input class="form-control" ng-show="tactictype.editing" ng-model="tactictype.name" style="min-width: 50%;width: auto;float: left;margin-right: 3px;">
                    <span ng-show="tactictype.editing"><a ng-click="vm.save(tactictype)" class="btn btn-success">Save</a> <a ng-click="vm.cancel(tactictype)" class="btn btn-default">Cancel</a></span>
				</td>
			</tr>
		</tbody>
	</table>
</div>
<script src="/js/angular/milestones/tacticFactory.js"></script>
<script src="/js/angular/admin/tactic/tacticTypeController.js"></script>
<script src="/js/angular/admin/tactic/modals/deleteTacticType.js"></script>
@stop