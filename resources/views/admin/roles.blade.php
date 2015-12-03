@extends('layouts.main')

@section('title')
Admin Settings
@stop

@section('body')
<h1>User Roles</h1>
<div class="listRoles" ng-controller="RoleController as roleCtrl">
	<table ng-cloak class="table table-striped table-hover">
		<thead>
			<tr>
				<th>Actions</th>
				<th>Name</th>
			</tr>
		</thead>
		<tbody>
			<tr ng-repeat="role in roleCtrl.roles">
				<td>
					<span style='cursor:pointer;font-size:1.3em' class='fa fa-times text-danger' ng-hide="role.name == 'administrator'" ng-click="roleCtrl.delete(role.name)"></span>
				</td>
				<td>@{{role.name}}</td>
			</tr>
		</tbody>
	</table>
<button type="button" class="btn btn-success" ng-click="roleCtrl.showCreateForm = !roleCtrl.showCreateForm">New Role</button>
<br><br>
<form class="form-horizontal col-lg-6" ng-show="roleCtrl.showCreateForm">
{!! csrf_field() !!}
<fieldset>
	<legend>Create Role</legend>
	<div class="form-group">
		<label for="role" class="col-lg-2 control-label">Role Name</label>
		<div class="col-lg-10">
			<input type="text" name="role" class="form-control" ng-model="roleCtrl.newRoleName">
		</div>
	</div>
	<div class="form-group">
		<div class="col-lg-10 col-lg-offset-2">
			<button type="button" class="btn btn-primary" ng-click="roleCtrl.create()">Save</button>
		</div>
	</div>
</fieldset>
</form>
</div>
<script src="/js/angular/admin/role/roleFactory.js"></script>
<script src="/js/angular/admin/role/roleController.js"></script>
<script src="/js/angular/admin/role/modals/deleteRole.js"></script>
@stop