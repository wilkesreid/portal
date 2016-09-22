@extends('layouts.main')

@section('title')
Portal - Milestones
@stop

@push('styles')
<style>
    @media (max-width:499px) {
        .hide-mobile {
            display: none;
        }
        .milestone_list td {
            display: block;
            width: 100%;
            text-align: center;
        }
        .milestone_list .input-group-btn {
            display: none;
        }
        .milestone_list .input-group,
        .milestone_list .input-group input {
            width: 100%;
            font-size: 1.3rem;
        }
        .panel-body {
            padding: 15px 5px;
        }
        /* The Harvest popup is not responsive, so until we figure out a way to make it responsive, we'll hide the tracking icon */
        .harvest-timer {
            /*display: none;*/
        }
        /* Attempt at adding responsivity */
        #harvest-iframe {
            top: 50% !important;
            transform: translate(28%, -50%);
            width: 320px !important;
        }
        .harvest-timer-icon {
            display: none;
        }
    }
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
	.clickable {
    	cursor: pointer;
	}
	.panel-body h3, .panel-body h4, .panel-body h5 {
    	margin-top: 0;
	}
	.harvest-timer {
    	
	}
</style>
@endpush

@section('body')
<h1>Milestones</h1>
<div ng-cloak ng-controller="milestonesController as vm">
	@can('create-milestone')
	<button type="button" class="btn btn-success" ng-hide="vm.loadingCompanies" ng-click="vm.createMilestone()"><span class="glyphicon glyphicon-plus"></span> New Milestone</button>
	@endcan
	<!--<br>
	<button type="button" class="btn btn-default" ng-hide="vm.loading" ng-click="vm.getCompanies()"><span class="fa fa-refresh"></span> Refresh</button>-->
	<br><br>
	<div class="alert alert-dismissible alert-danger" ng-repeat="warning in vm.warnings">
      <button type="button" class="close" data-dismiss="alert" ng-click="vm.dismissWarning(warning)">&times;</button>
      <strong>Error:</strong> @{{ warning.message }}
    </div>
	<div style="margin:0 auto;width:50%;"><input type="text" class="form-control" ng-model="vm.search" placeholder="Search"></div>
	<br>
	<div ng-show="vm.loading" style="text-align:center">
    	<h3 ng-show="vm.loadingCompanies">Loading companies...</h3>
    	<h3 ng-show="vm.loadingProjects">Loading projects...</h3>
    	<h3 ng-show="vm.loadingMilestones">Loading milestones...</h3>
    	<h3 ng-show="vm.loadingHarvestProjects">Loading Harvest projects...</h3>
    	<h3 ng-show="vm.loadingHarvestClients">Loading Harvest clients...</h3>
    	<h3 ng-show="vm.loadingHarvestTeamwork">Loading Harvest-Teamwork relationships...</h3>
		<div class="progress progress-striped active">
          <div class="progress-bar" style="width: 100%"></div>
        </div>
	</div>
	
	<div class="panel panel-default" ng-repeat="company in vm.visible_companies">
    	<div class="panel-heading clickable" ng-click="company.isCollapsed = !company.isCollapsed">@{{ company.name }}</div>
    	<div uib-collapse="company.isCollapsed" class="panel-body">
        	<h4 ng-if="company.projects.length > 1">Projects</h4>
        	<div class="panel panel-default" ng-if="company.projects.length > 1" ng-repeat="project in company.projects">
            	<div class="panel-heading clickable" ng-click="project.isCollapsed = !project.isCollapsed">@{{ project.name }}</div>
            	<div uib-collapse="project.isCollapsed" class="panel-body">
                	<h4 ng-if="project.milestones.length > 0">Milestones</h4>
                	<h4 ng-if="project.milestones.length < 1">No milestones yet!</h4>
                	<table class="table table-striped table-hover" ng-if="project.milestones.length > 0">
            		<thead>
            			<tr class="hide-mobile">
            				<!--<th>Actions</th>-->
            				<th>Harvest</th>
            				<th>Name</th>
            			</tr>
            		</thead>
            		<tbody>
            		<tr class="milestone_list" ng-repeat="milestone in project.milestones">
            			<!--<td>
            				<span style="cursor:pointer;font-size:1.2em;" ng-click="vm.destroyMilestone(milestone.id)" class="fa fa-times text-danger"></span>
            			</td>-->
            			<td>
                			{{-- <div ng-click="vm.openTimeModal(milestone.harvestProject, milestone)" ng-if="milestone.harvestProject != null" style="cursor:pointer;color:#f76c21;font-size:2.9em" class="fa fa-clock-o"></div>
                			<div ng-click="vm.connectHarvest(milestone)" ng-if="milestone.harvestProject == null" style="cursor:pointer;color:#888;font-size:2.9em" class="fa fa-clock-o"></div> --}}
                			<div class="harvest-timer fa fa-clock-o" style="cursor:pointer;color:#f76c21;font-size:2.9em"
                              data-item='{"id":@{{ milestone.id }},"name":"@{{ milestone.title }} "}'>
                            </div>
            			</td>
            			<td>
            			<span class="input-group">
            			<input type="text" value="@{{ milestone.title }}" id="milestone-@{{milestone.id}}" class="form-control">
            			<span class="input-group-btn">
            			<button type="button" class="btn btn-default" ngclipboard ngclipboard-error="vm.copyError(event)" ngclipboard-success="vm.copySuccess(event)" data-clipboard-target="#milestone-@{{milestone.id}}" uib-popover="@{{vm.copyPopup}}" popover-trigger="mouseenter" popover-append-to-body="true" ng-mouseleave="vm.resetCopyPopup()">
            				<span class="fa fa-clipboard"></span>
            			</button>
            			</span>
            			</span>
            			</td>
            		</tr>
            		</tbody>
                	</table>
            	</div>
        	</div>
        	<h4 ng-if="company.projects.length == 1">Milestones</h4>
        	<table class="table table-striped table-hover" ng-if="company.projects.length == 1">
    		<thead>
    			<tr class="hide-mobile">
    				<!--<th>Actions</th>-->
    				<th>Harvest</th>
    				<th>Name</th>
    			</tr>
    		</thead>
    		<tbody>
    		<tr class="milestone_list" ng-repeat="milestone in company.projects[0].milestones">
    			<!--<td>
    				<span style="cursor:pointer;font-size:1.2em;" ng-click="vm.destroyMilestone(milestone.id)" class="fa fa-times text-danger"></span>
    			</td>-->
    			<td>
        			{{-- <div ng-click="vm.openTimeModal(milestone.harvestProject, milestone)" ng-if="milestone.harvestProject != null" style="cursor:pointer;color:#f76c21;font-size:2.9em" class="fa fa-clock-o"></div>
        			<div ng-click="vm.connectHarvest(milestone)" ng-if="milestone.harvestProject == null" style="cursor:pointer;color:#888;font-size:2.9em" class="fa fa-clock-o"></div> --}}
        			<div class="harvest-timer fa fa-clock-o" style="cursor:pointer;color:#f76c21;font-size:2.9em"
                      data-item='{"id":@{{ milestone.id }},"name":"@{{ milestone.title }} "}'>
                    </div>
    			</td>
    			<td>
    			<span class="input-group">
    			<input type="text" value="@{{ milestone.title }}" id="milestone-@{{milestone.id}}" class="form-control">
    			<span class="input-group-btn">
    			<button type="button" class="btn btn-default" ngclipboard ngclipboard-error="vm.copyError(event)" ngclipboard-success="vm.copySuccess(event)" data-clipboard-target="#milestone-@{{milestone.id}}" uib-popover="@{{vm.copyPopup}}" popover-trigger="mouseenter" popover-append-to-body="true" ng-mouseleave="vm.resetCopyPopup()">
    				<span class="fa fa-clipboard"></span>
    			</button>
    			</span>
    			</span>
    			</td>
    		</tr>
    		</tbody>
        	</table>
    	</div> 
	</div>
</div>

<script src="/js/integrations/harvest/button.js"></script>
<script src="/js/angular/milestones/teamworkFactory.js"></script>
<script src="/js/angular/milestones/harvest/harvestFactory.js"></script>
<script src="/js/angular/milestones/tacticFactory.js"></script>
<script src="/js/angular/milestones/milestonesController.js"></script>
<script src="/js/angular/milestones/modals/newMilestone.js"></script>
<script src="/js/angular/milestones/modals/deleteMilestone.js"></script>
<script src="/js/angular/milestones/modals/editMilestone.js"></script>

<script defer>
    !function($){
      $(".harvest-timer.styled").removeClass("styled");
      $(".harvest-timer-icon").remove();
    }(jQuery);
</script>

@stop