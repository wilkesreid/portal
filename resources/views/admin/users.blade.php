@extends('layouts.main')

@section('title')
Users
@stop

@section('body')
<h1>Users</h1>
<table class="table table-striped table-hover">
	<thead>
	<tr>
		<th></th>
		<th>Name</th>
		<th>Email</th>
		<th>Role</th>
	</tr>
	</thead>
	<tbody>
@foreach (App\User::all() as $user)
<tr>
<td ng-controller="deleteUserModalController as modal">
<a style="cursor:pointer" ng-click="modal.open({{$user->id}},'{{$user->name}}')"><span class="glyphicon glyphicon-remove"></span></a>
&nbsp;
&nbsp;
<a href="/admin/users/{{$user->id}}"><span class="glyphicon glyphicon-edit"></span></a></td>
<td>{{ $user->name }}</td>
<td>{{ $user->email }}</td>
<td>{{ $user->settings->role }}</td>
</tr>
@endforeach
	</tbody>
</table>
<script type="text/ng-template" id="confirmDeleteModal.html">
	<div class="modal-header">
		<h3 class="modal-title">Delete @{{ iModal.name }}</h3>
	</div>
	<div class="modal-body">
		<div class="alert alert-danger">
			<strong>This cannot be undone.</strong> Are you sure you want to proceed?
		</div>
	</div>
	<div class="modal-footer">
		<button class="btn btn-default" type="button" ng-click="iModal.cancel()">Cancel</button>
		<button class="btn btn-danger" type="button" ng-click="iModal.ok()">Delete</button>
	</div>
</script>
<script src="/js/angular/deleteUserModal.js"></script>
@stop