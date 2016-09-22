@extends('layouts.auditform')

<?php

use App\AuditForm;
use App\AuditFormField;

$form = AuditForm::find($id);

$frozen = $form->frozen;

$fields = $form->fields;
	
?>
@push('styles')
<style>
    h2 {
        font-weight: bold;
    }
    .end {
        text-align: center;
        font-size: .8em;
        padding-top: 150px;
    }
    .editing:hover {
        border: 1px solid #ccc96e;
    }
    textarea {
        min-height: 43px;
        resize: none !important;
    }
    .ui-slider-tick {
        position: absolute;
        background-color: #aaa;
        width: 2px;
        height: 8px;
        top: 16px;
    }
    boolean,
    choices {
        height: 43px;
        display: block;
        padding: 10px 0;
    }
    boolean .col-sm-6 {
        max-width: 160px;
    }
    .choice-label {
        margin-left: 10px;
    }
    .navbar {
        position: fixed;
        width: 100%;
        z-index: 100;
    }
    body > div > div {
        padding-top: 52px;
    }
    @media print {
        * {
            page-break-inside: avoid;
        }
        boolean div, choices div {
            float: left;
        }
        textarea {
            min-height: 150px;
        }
    }
</style>
@endpush

@section('title')
{{ $form->name }}
@endsection

@section('body')
<div ng-controller="formController as vm">
@if ( Auth::check() )
<nav ng-cloak class="navbar navbar-default" role="navigation" ng-controller="NavbarController as nav">
	<div class="container-fluid">
		<div class="navbar-header">
        <button type="button" class="navbar-toggle" ng-click="nav.collapsed = !nav.collapsed">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <!--<a class="navbar-brand" href="/">Form</a>-->
		</div>
		<div class="collapse navbar-collapse nav-collapse navbar-responsive-collapse" id="navbar-collapse" uib-collapse="nav.collapsed">
			<ul class="nav navbar-nav">				
    			<li><a href ng-click="vm.toggleFrozen()" ng-disabled="vm.frozenLoaded">@{{vm.frozen_text}}</a></li>
				<li><a href ng-click="vm.createField()">Add Field</a></li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li ng-show="vm.deleteHistory.length > 0"><a href ng-click="vm.undoDelete()">Undo Delete</a></li>
			</ul>
		</div> <!-- /.navbar-collapse -->
	</div> <!-- /.container-fluid -->
</nav>
@endif

<div class="container" ng-cloak>
    <h1 style="text-align:center">{{ $form->name }}</h1>
    <div class="form-group col-sm-@{{ field.column_size }}" ng-repeat="field in vm.fields track by field.id" <?php if (Auth::check()) {?>context-menu="vm.ctxMenu"<?php } ?>>
        <label class="control-label col-sm-12" ng-if="!field.tag.endsWith('heading')"><span ng-show="field.name == ''">&nbsp;</span>@{{ field.name }}</label>
        <div class="col-sm-12">
            <textarea ng-if="field.tag == 'textarea'" ng-model="field.value" msd-elastic="\n" ng-change="vm.sendFieldChange(field)" ng-model-options="{updateOn: 'blur'}" bg-attributes="field.attributes" ng-disabled="vm.frozen && !vm.logged_in"></textarea>
            <input ng-if="field.tag == 'input'" ng-model="field.value" ng-change="vm.sendFieldChange(field)" ng-model-options="{updateOn: 'blur'}" bg-attributes="field.attributes" ng-disabled="vm.frozen && !vm.logged_in">
            <boolean ng-if="field.tag == 'boolean'" ng-model="field.value" ng-click="vm.sendFieldChange(field)" ng-disabled="vm.frozen && !vm.logged_in"></boolean>
            <section-heading ng-if="field.tag == 'section-heading'" contents="field.name"></section-heading>
            <group-heading ng-if="field.tag == 'group-heading'" contents="field.name"></group-heading>
            <small-heading ng-if="field.tag == 'small-heading'" contents="field.name"></small-heading>
            <choices ng-if="field.tag == 'choices'" choices="field.options"></choices>
            <button ng-if="field.tag == 'file'" type="file" class="btn btn-default" ngf-select="vm.upload(field)" ng-model="field.file" ng-disabled="vm.frozen && !vm.logged_in">Upload</button>
            <a ng-if="field.tag == 'file' && field.value != ''" ng-href="https://s3.amazonaws.com/auditformfiles/@{{field.value}}" download class="btn btn-success">Download</a>
            <p ng-show="field.tag == 'file'">@{{ field.file.name }}</p>
            <div style="margin-top: 5px" class="progress progress-striped active" ng-show="field.tag == 'file' && field.file.progress != null &&  field.file.progress >= 0">
                <div class="progress-bar" style="width: @{{ field.file.progress }}%"></div>
            </div>
        </div>
    </div>
    <div class="col-sm-12" ng-show="vm.loading" style="text-align:center">
		<img src="/images/ajax-loader.svg">
	</div>
	<div class="col-sm-12" ng-show="vm.loadError" style="text-align:center">
    	<span class="fa fa-exclamation fa-4x" style="color:red"></span>
    	<p>There has been an error. Please refresh the page.</p>
	</div>
</div>
<p class="end" ng-hide="vm.loading">----- End of Form -----</p>
</div>
<script>
    window.form_id = "{{ $id }}";
    window.form_frozen = {{ $frozen }};
    @if ( Auth::check() )
    window.logged_in = true;
    @else
    window.logged_in = false;
    @endif
</script>
<script src="/js/lib/uuid.js"></script>
<script src="/js/angular/auditforms/formFactory.js"></script>
<script src="/js/angular/auditforms/formController.js"></script>
<script src="/js/angular/auditforms/modals/editForm.js"></script>
<script src="/js/angular/auditforms/modals/createField.js"></script>
<script src="/js/angular/auditforms/modals/createFieldAfter.js"></script>
</div>
@endsection