@extends('layouts.main')

@section('title')
Portal - Websites
@stop

@section('body')
<h1>Bureau Gravity Websites</h1>
<div class="help-block">
This list is for keeping track of how often Bureau Gravity websites have been checked for overall correctness.
</div>
<div ng-cloak ng-controller="WebsiteListController as listCtrl">
	@if (!Gate::denies('edit-websites'))
	<button type="button" class="btn btn-success" ng-click="listCtrl.create()"><span class="glyphicon glyphicon-plus"></span> New Website</button>
	@endif
	<table class="table table-striped table-hover">
		<thead>
			<tr>
				@if (!Gate::denies('edit-websites'))
				<th style="text-align:center; max-width:75px">Checked In The Last {{ \App\Setting::getValue('website_check_days') }} Days</th>
				@endif
				<th>Website Name</th>
				<th>URL</th>
				<th>Last Checked</th>
			</tr>
		</thead>
		<tbody>
			<tr ng-repeat="website in listCtrl.websites" ng-class="{danger: website.malware == true, warning: website.pixel != true }">
				@if (!Gate::denies('edit-websites'))
				<!--<td>
					@if (!Gate::denies('delete-websites'))
					<span style="cursor:pointer;font-size:1.2em;" ng-click="listCtrl.delete(client.id,client.name)" class="fa fa-times text-danger"></span>
					&nbsp;&nbsp;
					@endif
					<span style="cursor:pointer;font-size:1.2em;" ng-click="clientListCtrl.edit(client.id,client.name)" class="fa fa-pencil text-warning"></span>
				</td>-->
				<td style="text-align: center">
					<input ng-click="listCtrl.markChecked(website.id)" type="checkbox" ng-model="website.checked"> <a uib-popover="Undo" popover-trigger="mouseenter" popover-append-to-body="true" style="text-decoration:none;margin-left:10px" href="javascript:void(0)" class="@{{ (website.checked) ? 'fa fa-undo' : ''}}" ng-click="listCtrl.uncheck(website.id)"></a>
				</td>
				@endif
				<td><a href="/files/websites/@{{website.name}}.pdf" target="_blank">@{{website.name}}</a></td>
				<td><a href="@{{listCtrl.absUrl(website.url)}}" target="_blank">@{{listCtrl.absUrl(website.url)}}</a></td>
				<td>@{{(website.checked_last != "0000-00-00" && website.checked_last != "" && website.checked_last != null) ? (website.checked_last | date:"MM/dd/yy") : "Never"}}</td>
			</tr>
		</tbody>
	</table>
	<div ng-show="listCtrl.loading" style="text-align:center">
		<img src="/images/ajax-loader.svg">
	</div>
</div>

<script src="/js/angular/website/websiteFactory.js"></script>
<script src="/js/angular/website/websiteListController.js"></script>
<script src="/js/angular/website/modals/deleteWebsite.js"></script>
<script src="/js/angular/website/modals/editWebsite.js"></script>
<script src="/js/angular/website/modals/newWebsite.js"></script>


@stop