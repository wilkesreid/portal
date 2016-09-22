@extends('layouts.main')

@section('title', 'Portal - Audit Forms')

@section('body')
<h1>Audit Forms</h1>
<div ng-cloak ng-controller="formListController as vm">
	<a href ng-click="vm.toggleCreateForm()" class="btn btn-success" ><span class="glyphicon glyphicon-plus"></span> New Form</a>
	<br>
	<div id="create-form" class="col-md-6" ng-show="vm.creating_form" style="background-color:#f4f4f4;padding:15px;margin: 10px;">
    	<label class="control-label col-md-2">Name</label>
    	<div class="col-md-10">
    	<input class="form-control" type="text" ng-model="vm.newForm.name">
    	</div>
    	<div class="col-md-offset-2 col-md-4" style="margin-top:10px;">
    	    <button class="btn btn-success" style="width:100%;" type="button" ng-click="vm.create()">Create</button>
    	</div>
	</div>
	<table class="table table-striped table-hover">
		<thead>
			<tr>
				<th>Actions</th>
				<th>Name</th>
			</tr>
		</thead>
		<tbody>
    		<tr ng-show="vm.forms.length < 1 && !vm.loading">
        		<td colspan="2">No audit forms! <a href ng-click="vm.toggleCreateForm()">Make one now.</a></td>
    		</tr>
			<tr ng-repeat="form in vm.forms">
				<td width="150">
					<span style="cursor:pointer;font-size:1.2em;" ng-click="vm.delete(form.id,form.name)" class="fa fa-times text-danger"></span>
					&nbsp;&nbsp;
					<span style="cursor:pointer;font-size:1.2em;" ng-click="vm.edit(form)" class="fa fa-pencil text-warning"></span>
					&nbsp;&nbsp;
					<span style="cursor:pointer;font-size:1.2em;" ng-click="vm.duplicate(form.id)" class="fa fa-files-o"></span>
				</td>
				<td>
    				<a ng-show="!form.editing" href="/form/@{{form.id}}" target="_blank">@{{form.name}}</a><input class="form-control" ng-show="form.editing" ng-model="form.name" style="min-width: 50%;width: auto;float: left;margin-right: 3px;">
                    <span ng-show="form.editing"><a ng-click="vm.save(form)" class="btn btn-success">Save</a> <a ng-click="form.editing = false" class="btn btn-default">Cancel</a></span>
				</td>
			</tr>
		</tbody>
	</table>
	<div ng-show="vm.loading" style="text-align:center">
		<img src="/images/ajax-loader.svg">
	</div>
</div>
<script src="/js/angular/auditforms/formFactory.js"></script>
<script src="/js/angular/auditforms/formListController.js"></script>
<script src="/js/angular/auditforms/modals/deleteForm.js"></script>
@endsection