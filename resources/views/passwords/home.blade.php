@extends('layouts.main')

@section('title')
Home
@stop

@section('body')
<h1>Password Manager</h1>
<div ng-cloak ng-controller="ClientListController as clientListCtrl">
	@if (!Gate::denies('edit-clients'))
	<button type="button" class="btn btn-success" ng-click="clientListCtrl.create()"><span class="glyphicon glyphicon-plus"></span> New Client</button>
	@endif
	<a class="btn btn-info" href="/clients/1">Internal</a>
	<br><br>
	<table class="table table-striped table-hover">
		<thead>
			<tr>
				@if (!Gate::denies('edit-clients'))
				<th>Actions</th>
				@endif
				<th>Client Name</th>
			</tr>
		</thead>
		<tbody>
			<tr ng-repeat="client in clientListCtrl.clients">
				@if (!Gate::denies('edit-clients'))
				<td>
					<span style="cursor:pointer;font-size:1.2em;" ng-click="clientListCtrl.delete(client.id,client.name)" class="fa fa-times text-danger"></span>
					&nbsp;&nbsp;
					<span style="cursor:pointer;font-size:1.2em;" ng-click="clientListCtrl.edit(client.id,client.name)" class="fa fa-pencil text-warning"></span>
				</td>
				@endif
				<td><a href="/clients/@{{client.id}}">@{{client.name}}</a></td>
			</tr>
		</tbody>
	</table>
	<div ng-show="clientListCtrl.loading">
		Loading...
	</div>
</div>

<script src="/js/angular/client/clientFactory.js"></script>
<script src="/js/angular/client/clientListController.js"></script>
<script src="/js/angular/client/modals/deleteClient.js"></script>
<script src="/js/angular/client/modals/editClient.js"></script>
<script src="/js/angular/client/modals/newClient.js"></script>


@stop