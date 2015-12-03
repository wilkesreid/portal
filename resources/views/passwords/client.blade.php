@extends('layouts.main')

@section('title')
Home
@stop

<?php
	$client = App\Client::where('id',$client_id)->first();
?>

@section('body')
<a class="btn btn-default" href="/clients"><span class="fa fa-arrow-left"></span> Back</a>
<h1>{{$client->name}}</h1>
<div ng-cloak ng-controller="PlatformListController as platformListCtrl">
	<button type="button" class="btn btn-success" ng-click="platformListCtrl.create()"><span class="glyphicon glyphicon-plus"></span> New Platform</button>
	<br><br>
	<table class="table table-striped table-hover">
		<thead>
			<tr>
				<th>Actions</th>
				<th>Platform Name</th>
				<th>Url</th>
			</tr>
		</thead>
		<tbody>
			<tr ng-repeat="platform in platformListCtrl.platforms">
				<td>
					<span style="cursor:pointer;font-size:1.2em;" ng-click="platformListCtrl.delete(platform.id,platform.name)" class="fa fa-times text-danger"></span>
					&nbsp;&nbsp;
					<span style="cursor:pointer;font-size:1.2em;" ng-click="platformListCtrl.edit(platform.id,platform.name,platform.url)" class="fa fa-pencil text-warning"></span>
				</td>
				<td><a href="/platforms/@{{platform.id}}">@{{platform.name}}</a></td>
				<td><a target="_blank" href="@{{platformListCtrl.absUrl(platform.url)}}">@{{platform.url}}</a></td>
			</tr>
		</tbody>
	</table>
	<div ng-show="platformListCtrl.loading">
		Loading...
	</div>
</div>

<script>
	window.client_id = {{$client_id}};
</script>
<script src="/js/angular/platform/platformFactory.js"></script>
<script src="/js/angular/platform/platformListController.js"></script>
<script src="/js/angular/platform/modals/createModal.js"></script>
<script src="/js/angular/platform/modals/deleteModal.js"></script>
<script src="/js/angular/platform/modals/editModal.js"></script>

@stop