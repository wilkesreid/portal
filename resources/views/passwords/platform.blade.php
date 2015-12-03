@extends('layouts.main')

@section('title')
Home
@stop

<?php
	$platform = App\Platform::where('id',$platform_id)->first();
?>

@section('body')
<a class="btn btn-default" href="/clients/{{$platform->client_id}}"><span class="fa fa-arrow-left"></span> Back</a>
<h1>{{$platform->name}}</h1>
<div ng-cloak ng-controller="CredentialListController as listCtrl">
	<button type="button" class="btn btn-success" ng-click="listCtrl.create()"><span class="glyphicon glyphicon-plus"></span> New User</button>
	&nbsp;&nbsp;
	<button type="button" class="btn btn-default" ng-click="listCtrl.viewTrash()"><span class="fa fa-trash"></span> View Old</button>
	<br><br>
	<table class="table table-striped table-hover">
		<thead>
			<tr>
				<th>Actions</th>
				<th>Username</th>
				<th>Password</th>
				<th>Comments</th>
			</tr>
		</thead>
		<tbody>
			<tr ng-repeat="credential in listCtrl.credentials">
				<td>
					<span style="cursor:pointer;font-size:1.2em;" ng-click="listCtrl.delete(credential.id,credential.username)" class="fa fa-times text-danger"></span>
					&nbsp;&nbsp;
					<span style="cursor:pointer;font-size:1.2em;" ng-click="listCtrl.edit(credential.id,credential.username,credential.password,credential.comments)" class="fa fa-pencil text-warning"></span>
				</td>
				<td style="cursor:pointer" uib-popover="Click to Copy" popover-trigger="mouseenter" popover-append-to-body="true" ngclipboard data-clipboard-text="@{{credential.username}}">@{{credential.username}}</td>
				<td style="cursor:pointer" uib-popover="Click to Copy" popover-trigger="mouseenter" popover-append-to-body="true" ngclipboard data-clipboard-text="@{{credential.password}}">@{{credential.password}}</td>
				<td style="cursor:pointer" uib-popover="Click to Copy" popover-trigger="mouseenter" popover-append-to-body="true" ngclipboard data-clipboard-text="@{{credential.url}}">@{{credential.comments}}</td>
			</tr>
		</tbody>
	</table>
	<div ng-show="listCtrl.loading">
		Loading...
	</div>
</div>

<script>
	window.platform_id = {{$platform_id}};
</script>
<script src="/js/angular/credential/credentialFactory.js"></script>
<script src="/js/angular/credential/credentialListController.js"></script>
<script src="/js/angular/credential/modals/createModal.js"></script>
<script src="/js/angular/credential/modals/deleteModal.js"></script>
<script src="/js/angular/credential/modals/editModal.js"></script>
<script src="/js/angular/credential/modals/trashModal.js"></script>

@stop