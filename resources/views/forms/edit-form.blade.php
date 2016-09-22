@extends('layouts.main')

<?php

use App\Form;

$form = Form::find($id);
	
?>

@section('title', 'Portal - Edit Form')

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
<h1>Edit Form</h1>
<div ng-cloak ng-controller="editFormController as vm">
	<button type="button" ng-click="vm.submit()" class="btn btn-success" ng-disabled="!vm.valid">Save</button>
	<hr>
	<div class="form-group row">
		<label class="col-lg-2 control-label">Name</label>
		<div class="col-lg-5">
			<input type="text" ng-model="vm.name" class="form-control">
		</div>
	</div>
	<div ng-repeat="field in vm.data">
		<div class="row" style="position:relative">
			<hr class="col-lg-7">
			<a ng-click="vm.removeField($index)" class="fa fa-trash icon-button" style="color:red;left:0;"></a>
			<!--<a ng-click="vm.newSubfield($index)" class="fa fa-plus icon-button" style="color:green;left:25px;"></a>-->
			<a ng-click="vm.insertNewField($index)" class="fa fa-plus icon-button" style="color:green;left:25px"></a>
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
			<label class="col-lg-2 control-label">Current Value</label>
			<div class="col-lg-5">
				<input ng-if="field.type != 'textarea'" type="@{{field.type}}" ng-model="field.value" ng-class="(vm.isTextType(field)) ? 'form-control' : ''">
				<textarea rows="7" ng-if="field.type == 'textarea'" ng-model="field.value" class="form-control"></textarea>
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
				<label class="col-lg-2 control-label">Current Value</label>
				<div class="col-lg-5">
					<input type="@{{subfield.type}}" ng-model="subfield.value" ng-class="(vm.isTextType(subfield)) ? 'form-control' : ''">
				</div>
			</div>
		</div>
	</div>
	<button type="button" ng-click="vm.newField()" class="btn btn-success" ><span class="glyphicon glyphicon-plus"></span> New Field</button>
	<br><br>
	<button type="button" ng-click="vm.submit()" class="btn btn-success" ng-disabled="!vm.valid">Save</button>
	<div ng-show="vm.loading" style="text-align:center">
		<img src="/images/ajax-loader.svg">
	</div>
</div>

<script>
	window.form_id = "{{ $form->id }}";
</script>
<script src="/js/angular/forms/formFactory.js"></script>
<script src="/js/angular/forms/editFormController.js"></script>

@endsection