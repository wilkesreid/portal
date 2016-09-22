@extends('layouts.main')

@section('title')
Portal - Milestones
@stop

@push('styles')
<style>
	.input-group {
		max-width: 450px;
	}
	div.company {
		margin-top: 50px;
	}
	table.collapse.in {
		display: table;
	}
	.company-name {
		cursor: pointer;
	}
	.company-name:hover {
		text-decoration: underline;
	}
	h1.company-name {
		font-size: 2em;
		font-weight: 400;
	}
</style>
@endpush

@section('body')
<h1>Milestones</h1>
<div ng-cloak ng-controller="babiesController as vm">
	<img src="/images/ajax-loader-small.svg" ng-show="vm.loading">
	<button type="button" class="btn btn-success" ng-hide="vm.loading" ng-click="vm.create()"><span class="glyphicon glyphicon-plus"></span> New</button>
	<div style="margin:0 auto;width:50%;"><input type="text" class="form-control" ng-model="vm.search" placeholder="Search"></div>
	<div ng-repeat="company in vm.visible_companies" class="company">
		<hr>
		<h1 class="company-name" ng-click="company.isCollapsed = !company.isCollapsed">@{{ company.name }}</h1>
	<table class="table table-striped table-hover" ng-repeat="project in company.projects" uib-collapse="company.isCollapsed">
		<thead>
			<tr>
				<th colspan="2"><h3>@{{ project.name }}</h3></th>
			</tr>
			<tr>
				<th>Actions</th>
				<th>Name</th>
			</tr>
		</thead>
		<tbody>
		<tr ng-repeat="baby in project.babies">
			<td>
				<span style="cursor:pointer;font-size:1.2em;" ng-click="vm.destroy(baby.id)" class="fa fa-times text-danger"></span>
				<img src="/images/ajax-loader-small.svg" ng-show="vm.loading">
			</td>
			<td>
			<span class="input-group">
			<input type="text" value="@{{ baby.name }}" id="baby-@{{project.id}}-@{{$index}}" class="form-control">
			<span class="input-group-btn">
			<button type="button" class="btn btn-default" ngclipboard ngclipboard-error="vm.copyError(event)" ngclipboard-success="vm.copySuccess(event)" data-clipboard-target="#baby-@{{project.id}}-@{{$index}}" uib-popover="@{{vm.copyPopup}}" popover-trigger="mouseenter" popover-append-to-body="true" ng-mouseleave="vm.resetCopyPopup()">
				<span class="fa fa-clipboard"></span>
			</button>
			</span>
			</span>
			</td>
		</tr>
		</tbody>
	</table>
	</div>
	<div ng-show="vm.loadingProjects || vm.loadingBabies || !vm.combinationComplete" style="text-align:center">
		<img src="/images/ajax-loader.svg">
	</div>
</div>

<script src="/js/angular/babies/babiesFactory.js"></script>
<script src="/js/angular/babies/tacticTypeFactory.js"></script>
<script src="/js/angular/babies/tacticFactory.js"></script>
<script src="/js/angular/babies/projectFactory.js"></script>
<script src="/js/angular/babies/userFactory.js"></script>
<script src="/js/angular/babies/companyFactory.js"></script>
<script src="/js/angular/babies/babiesController.js"></script>
<script src="/js/angular/babies/modals/newBaby.js"></script>
<script src="/js/angular/babies/modals/deleteBaby.js"></script>

@stop