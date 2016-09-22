@extends('layouts.main')

@section('title', 'Portal - Create Form')

@section('body')
<style>
	.icon-button {
		position: absolute;
		top: 25px;
	}
	.icon-button:hover {
		cursor: pointer;
		text-decoration: none;
	}
</style>
<a href="/forms" class="btn btn-default"><span class="fa fa-arrow-left"></span> Back</a>
<h1>Create Form</h1>
<hr>
<div ng-cloak ng-controller="createFormController as vm">
	<div class="form-group row">
		<label class="col-lg-2 control-label">Name</label>
		<div class="col-lg-5">
			<input type="text" ng-model="vm.name" class="form-control">
		</div>
	</div>
	<button type="button" ng-click="vm.submit()" class="btn btn-success" ng-disabled="!vm.valid">Create</button>
	<div ng-repeat="field in vm.data">
		<div class="row" style="position:relative">
			<hr class="col-lg-7">
			<a ng-click="vm.removeField($index)" class="fa fa-trash icon-button" style="color:red;left:0;"></a>
			<a ng-click="vm.insertNewField($index)" class="fa fa-plus icon-button" style="color:green;left:25px;"></a>
		</div>
		<div class="form-group row" ng-if="field.type != 'separator'">
			<label class="col-lg-2 control-label">Field Name</label>
			<div class="col-lg-5">
				<input type="text" ng-model="field.name" class="form-control">
			</div>
		</div>
		<div class="form-group row">
			<label class="col-lg-2 control-label">Field Type</label>
			<div class="col-lg-5">
				<select class="form-control" ng-options="fieldType for fieldType in vm.fieldTypes track by fieldType" ng-model="field.type"></select>
			</div>
		</div>
		<div class="form-group row" ng-if="field.type != 'label' && field.type != 'header' && field.type != 'separator'">
			<label class="col-lg-2 control-label">Default Value</label>
			<div class="col-lg-5">
				<input ng-if="field.type != label" type="@{{field.type}}" ng-model="field.value" ng-class="(vm.isTextType(field)) ? 'form-control' : ''">
			</div>
		</div>
		<div class="col-lg-offset-2" ng-repeat="subfield in field.subfields">
			<div class="row" style="position:relative">
				<hr class="col-lg-7">
				<a href="#" ng-click="vm.removeSubField(field,$index)" class="fa fa-trash" style="color:red;position:absolute;left:0;top:25px;"></a>
			</div>
			<div class="form-group row">
				<label class="col-lg-2 control-label">Field Name</label>
				<div class="col-lg-5">
					<input type="text" ng-model="subfield.name" class="form-control">
				</div>
			</div>
			<div class="form-group row">
				<label class="col-lg-2 control-label">Field Type</label>
				<div class="col-lg-5">
					<select class="form-control" ng-options="fieldType for fieldType in vm.fieldTypes track by fieldType" ng-model="subfield.type"></select>
				</div>
			</div>
			<div class="form-group row" ng-if="field.type != 'label'">
				<label class="col-lg-2 control-label">Default Value</label>
				<div class="col-lg-5">
					<input type="@{{subfield.type}}" ng-model="subfield.value" ng-class="(vm.isTextType(subfield)) ? 'form-control' : ''">
				</div>
			</div>
		</div>
	</div>
	<button type="button" ng-click="vm.newField()" class="btn btn-success" ><span class="glyphicon glyphicon-plus"></span> New Field</button>
</div>

<script src="/js/angular/forms/formFactory.js"></script>
<script src="/js/angular/forms/createFormController.js"></script>

@endsection