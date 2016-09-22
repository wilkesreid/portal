@extends('layouts.form')

<?php

use App\Form;

$form = Form::find($id);
	
?>

@section('title')
{{ $form->name }}
@endsection

@section('body')
<style>
	hr {
		border-top: 1px solid #999999;
	}
</style>
<h1 style="text-align:center">{{ $form->name }}</h1>
<hr class="col-lg-8 col-lg-offset-2">
<div ng-cloak ng-controller="formController as vm" class="col-lg-8 col-lg-offset-2">
	
	<div ng-show="vm.loading" style="text-align:center">
		<img src="/images/ajax-loader.svg">
	</div>
	
	<div ng-repeat="field in vm.fields">
		<hr ng-if="field.type == 'separator'">
		<div class="form-group row" ng-if="field.type != 'separator'">
			<label class="col-lg-3 control-label" ng-if="field.type != 'label' && field.type != 'header'">@{{ field.name }}</label>
			<div class="col-lg-9">
				<h3 ng-if="field.type == 'label'">@{{ field.name }}</h3>
				<h1 ng-if="field.type == 'header'">@{{ field.name }}</h1>
				<input ng-if="field.type != 'label' && field.type != 'header' && field.type != 'textarea'" type="@{{ field.type }}" ng-class="(vm.isTextType(field)) ? 'form-control' : ''" keep-focus ng-model-options="{ debounce: 100 }" ng-model="field.value" ng-blur="vm.sendUpdate()" on-enter="vm.blur($event)" ng-change="vm.sendUpdate()">
				<textarea rows="7" ng-if="field.type == 'textarea'" class="form-control" keep-focus ng-model-options="{ debounce: 100} " ng-model="field.value" ng-blur="vm.sendUpdate()" on-enter="vm.blur($event)" ng-change="vm.sendUpdate()"></textarea>
				</div>
			</div>
		<div class="row col-lg-offset-1">
			<div class="col-lg-12 row" ng-repeat="subfield in field.subfields">
				<div class="form-group row">
				<label class="col-lg-3 control-label" ng-if="subfield.type != 'label'">@{{ subfield.name }}</label>
				<div class="col-lg-9">
					<h2 ng-if="subfield.type == 'label'">@{{ field.name }}</h2>
					<input ng-if="subfield.type != 'label'" type="@{{ subfield.type }}" ng-class="(vm.isTextType(subfield)) ? 'form-control' : ''" keep-focus ng-model-options="{ debounce: 100 }" ng-model="subfield.value" ng-blur="vm.sendUpdate()" on-enter="vm.blur($event)" ng-change="vm.sendUpdate()">
				</div>
			</div>
		</div>
		</div>
	</div>
	
</div>
<script>
	window.form_id = "{{ $form->id }}";
</script>
<script src="/js/angular/forms/formFactory.js"></script>
<script src="/js/angular/forms/formController.js"></script>

@endsection