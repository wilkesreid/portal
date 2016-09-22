@extends('layouts.main')

@section('title', 'Portal - Forms')

@section('body')
<h1>Forms</h1>
<div ng-cloak ng-controller="formListController as vm">
	<a href="/forms/create" class="btn btn-success" ><span class="glyphicon glyphicon-plus"></span> New Form</a>
	<table class="table table-striped table-hover">
		<thead>
			<tr>
				<th>Actions</th>
				<th>Form Name</th>
			</tr>
		</thead>
		<tbody>
			<tr ng-repeat="form in vm.forms">
				<td>
					<span style="cursor:pointer;font-size:1.2em;" ng-click="vm.delete(form.id,form.name)" class="fa fa-times text-danger"></span>
					&nbsp;&nbsp;
					<a style="cursor:pointer;font-size:1.2em;text-decoration: none;border: none" href="/forms/edit/@{{form.id}}" class="fa fa-pencil text-warning"></a>
					&nbsp;&nbsp;
					<span style="cursor:pointer;font-size:1.2em;" ng-click="vm.duplicate(form.id)" class="fa fa-files-o"></span>
				</td>
				<td><a href="/forms/@{{form.id}}" target="_blank">@{{form.name}}</a></td>
			</tr>
		</tbody>
	</table>
	<div ng-show="vm.loading" style="text-align:center">
		<img src="/images/ajax-loader.svg">
	</div>
</div>
<script src="/js/angular/forms/formFactory.js"></script>
<script src="/js/angular/forms/formListController.js"></script>
<script src="/js/angular/forms/modals/deleteForm.js"></script>
@endsection