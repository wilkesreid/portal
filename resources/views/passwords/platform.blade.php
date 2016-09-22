@extends('layouts.main')

@section('title')
Portal - Password Manager
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
					<span style="cursor:pointer;font-size:1.2em;" ng-click="listCtrl.edit(credential.id,credential.username,credential.password,credential.comments,credential.type)" class="fa fa-pencil text-warning"></span>
				</td>
				<td>
					<span class="input-group">
					<input type="text" value="@{{credential.username}}" id="username-@{{$index}}" class="form-control">
					<span class="input-group-btn">
					<button type="button" class="btn btn-default" ngclipboard ngclipboard-error="listCtrl.copyError(event)" ngclipboard-success="listCtrl.copySuccess(event)" data-clipboard-target="#username-@{{$index}}" uib-popover="@{{listCtrl.copyPopup}}" popover-trigger="mouseenter" popover-append-to-body="true" ng-mouseleave="listCtrl.resetCopyPopup()">
						<span class="fa fa-clipboard"></span>
					</button>
					</span>
					</span>
				</td>				
				<td>
					<span class="input-group">
					<input type="text" value="@{{credential.password}}" id="password-@{{$index}}" class="form-control">
					<span class="input-group-btn">
					<button type="button" class="btn btn-default" ngclipboard ngclipboard-error="listCtrl.copyError(event)" ngclipboard-success="listCtrl.copySuccess(event)" data-clipboard-target="#password-@{{$index}}" uib-popover="@{{listCtrl.copyPopup}}" popover-trigger="mouseenter" popover-append-to-body="true" ng-mouseleave="listCtrl.resetCopyPopup()">
						<span class="fa fa-clipboard"></span>
					</button>
					</span>
					</span>
				</td>
				<td style="min-width:300px">@{{credential.comments}}</td>
			</tr>
		</tbody>
	</table>
	<div ng-show="listCtrl.loading" style="text-align:center">
		<img src="/images/ajax-loader.svg">
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