!function(){
	
	angular.module('app')
	.controller('milestonesController', ['$scope', 'Teamwork', 'Tactic', 'Harvest', '$uibModal', milestonesController]);
	
	function milestonesController($scope, Teamwork, Tactic, Harvest, $uibModal) {
		
		var vm = this;
		
		// Variable declarations
		vm.loading = false;
		
		vm.milestones = [];
		vm.loadingMilestones = false;
		
		vm.tacticTypes = [];
		vm.loadingTacticTypes = false;
		
		vm.tactics = [];
		vm.loadingTactics = false;
		
		vm.projects = [];
		vm.loadingProjects = false;
		
		vm.companies = [];
		vm.visible_companies = vm.companies;
		vm.loadingCompanies = false;
		window.getCompanies = function() {return vm.companies};
		
		vm.harvestProjects = [];
		vm.loadingHarvestProjects = false;
		
		vm.twHarvestRelationships = [];
		vm.loadingHarvestTeamwork = false;
		
		vm.harvestClients = [];
		vm.loadingHarvestClients = false;
		
		vm.search = "";
		
		vm.copyPopup = "Click to Copy";
		
		vm.warnings = [];
		
		// Function declarations
		vm.getMilestones = getMilestones;
		vm.getAllMilestones = getAllMilestones;
		vm.getHarvestProjects = getHarvestProjects;
		vm.getHarvestTeamwork = getHarvestTeamwork;
		vm.getHarvestClients = getHarvestClients;
		vm.connectHarvest = connectHarvest;
		vm.openTimeModal = openTimeModal;
		vm.createMilestone = createMilestone;
		vm.getProjects = getProjects;
		vm.getAllProjects = getAllProjects;
		vm.getCompanies = getCompanies;
		vm.getTacticTypes = getTacticTypes;
		vm.getTactics = getTactics;
		vm.copySuccess = copySuccess;
		vm.copyError = copyError;
		vm.resetCopyPopup = resetCopyPopup;
		vm.destroyMilestone = destroyMilestone;
		vm.warn = warn;
		vm.dismissWarning = dismissWarning;
		
		// Initial function calls (to do things as soon as the controller is created)
		vm.getCompanies();
		vm.getTacticTypes();
		
		// Loading is always true unless every individual loading boolean is false.
		$scope.$watch('[vm.loadingTacticTypes,vm.loadingTactics,vm.loadingProjects,vm.loadingCompanies,vm.loadingMilestones,vm.loadingHarvestProjects,vm.loadingHarvestTeamwork,vm.loadingHarvestClients]',function(nu,old) {
			vm.loading = vm.loadingMilestones || vm.loadingTacticTypes || vm.loadingTactics || vm.loadingProjects || vm.loadingCompanies || vm.loadingHarvestProjects || vm.loadingHarvestTeamwork || vm.loadingHarvestClients;
			if (!vm.loading) {
        harvestButtons();
			}
		},true);
		
		
		function getMilestones(project_id) {
			
			vm.loadingMilestones = true;
			
			Teamwork.getMilestones(project_id)
			.success(function(response){
				vm.milestones = response;
				vm.loadingMilestones = false;
			});
		}
		
		function getAllMilestones() {
    		
    		
    		
    		vm.loadingMilestones = true;
    		
    		Teamwork.getAllMilestones()
    		.success(function(response){
        		vm.milestones = response.milestones;
        		
        		// Fix milestone names & remove completed milestones
        		_.each(vm.milestones,function(milestone){
            		var last_char = milestone.title.substring(milestone.title.length - 1, milestone.title.length);
            		if (last_char != ':') {
                		milestone.title += ':';
            		}
        		});
        		
        		// Remove completed milestones
        		vm.milestones = _.filter(vm.milestones,function(milestone){
            		return milestone.completed != true;
        		});
        		
        		// Assign milestones to their corresponding projects
        		_.each(vm.companies, function(company){
            		var num_milestones = 0;
            		_.map(company.projects, function(project){
                		project.milestones = _.filter(vm.milestones,function(milestone){
                    		return milestone['project-id'] == project.id;
                		});
                		num_milestones += project.milestones.length;
                		project.isCollapsed = true;
            		});
            		company.num_milestones = num_milestones;
        		});
        		
        		vm.loadingMilestones = false;
        		
        		//vm.getHarvestProjects();
    		})
    		.error(function(response){
        		console.error(response);
    		});
		}
		
		function createMilestone() {
			var modalInstance = $uibModal.open({
				animation: true,
				templateUrl: '/js/angular/milestones/modals/createMilestoneModal.html',
				controller: 'NewMilestoneModalInstanceController as mc',
				resolve: {
					parent_vm: function() {
						return vm;
					}
				}
			});
			
			modalInstance.result.then(function(data){
				Teamwork.createMilestone(data)
				.success(function(response){
    				if (response.success) {
        				if (response.response.STATUS == "Error") {
            				console.error("From Teamwork: "+response.response.MESSAGE);
        				} else {
					        console.log(response);
					        vm.getAllMilestones();
					    }
					} else {
    					switch (response.errcode) {
        					case 39: console.log(response.message); break;
        					case 40: vm.warn('You do not have permission to create Milestones in Teamwork'); break;
        					case 41: vm.warn('Could not create a Milestone with the information provided. Make sure you fill out every field.'); break;
        					default: vm.warn('An unknown error occurred.'); break;
    					}
					}
				})
				.error(function(response){
					console.error(response);	
				});
			});
		}
		
		function getTacticTypes() {
			vm.loadingTacticTypes = true;
			Tactic.getTacticTypes()
			.success(function(response){
				vm.tacticTypes = response;
				vm.loadingTacticTypes = false;
			});
		}
		
		function getTactics(tactictype_id) {
			vm.loadingTactics = true;
			Tactic.getTactics(tactictype_id)
			.success(function(response){
    			_.map(vm.tacticTypes, function(tactictype){
        			if (tactictype.id == tactictype_id) {
            			tactictype.tactics = response;
        			}
    			})
				vm.loadingTactics = false;
			});
		}
		
		function getProjects(company_id) {
			vm.loadingProjects = true;
			Teamwork.getProjects(company_id)
			.success(function(response){
				//console.log(response);
			});
		}
		
		function getAllProjects() {
    		vm.loadingProjects = true;
    		Teamwork.getAllProjects()
    		.success(function(response){
        		vm.projects = response.projects;
        		// Give all company objects an array of their projects as their own projects property
        		_.map(vm.companies,function(company){
            		company.projects = _.filter(vm.projects,function(project){
                		return project.company.id == company.id;
            		});
            		company.isCollapsed = true;
        		});
        		// Remove all companies that have no projects
        		vm.companies = _.filter(vm.companies, function(company) {
            		return company.projects.length > 0;
        		});
        		vm.visible_companies = _.clone(vm.companies);
        		vm.loadingProjects = false;
        		
        		vm.getAllMilestones();
    		})
    		.error(function(response){
        		console.error(response);
            });
		}
		
		function getCompanies() {
    		vm.companies = [];
			vm.loadingCompanies = true;
			Teamwork.getCompanies()
			.success(function(response){
    			vm.companies = response.companies;
				_.map(vm.companies,function(company){
					company.isCollapsed = true;
				});
				vm.loadingCompanies = false;
				vm.visible_companies = _.clone(vm.companies);
				
				vm.getAllProjects();
			})
			.error(function(response){
    			console.error(response);
            });
		}
		
		function destroyMilestone(milestone_id) {
			var modalInstance = $uibModal.open({
				animation:true,
				templateUrl: '/js/angular/milestones/modals/deleteMilestoneModal.html',
				controller: 'DeleteMilestoneModalInstanceController as mc'
			});
			
			modalInstance.result.then(function(){
				Teamwork.destroyMilestone(milestone_id)
				.success(function(response){
					vm.get();
				})
				.error(function(response){
					console.error(response);
				});
			});
		}
		
		// Harvest 
		
		function getHarvestProjects() {
    		vm.loadingHarvestProjects = true;
    		Harvest.getProjects()
    		.success(function(response){
        		vm.harvestProjects = _.map(response, function(project){
            		return project.project;
        		});
        		vm.harvestProjects = _.filter(vm.harvestProjects, function(project){
            		return project.active == true;
        		});
        		window.getHarvestProjects = function() { return vm.harvestProjects; };
        		//console.log(response);
        		vm.loadingHarvestProjects = false;
        		vm.getHarvestTeamwork();
        		vm.getHarvestClients();
    		})
    		.error(function(response){
        		console.error(response);
    		});
		}
		
		function getHarvestClients(){
    		vm.loadingHarvestClients = true;
    		Harvest.getClients()
    		.success(function(response){
        		vm.harvestClients = _.map(response, function(client){
            		return client.client;
                });
        		_.each(vm.harvestProjects, function(project){
            		project.client = _.find(vm.harvestClients,function(client){
                		return client.id == project.client_id;
            		});
        		});
        		vm.loadingHarvestClients = false;
    		});
		}
		
		function getHarvestTeamwork() {
    		vm.loadingHarvestTeamwork = true;
    		Harvest.getTeamwork()
    		.success(function(response){
        		vm.twHarvestRelationships = response;
        		window.getTwHarvest = function(){return vm.twHarvestRelationships;};
        		_.each(vm.twHarvestRelationships, function(relationship){
            		var milestone = _.find(vm.milestones, function(milestone){
                		return milestone.id == relationship.teamwork_milestone_id;
            		});
            		if (milestone != undefined) {
                		var harvest_project = _.find(vm.harvestProjects,function(project){
                    		return project.id == relationship.harvest_project_id;
                		});
                		if (harvest_project != undefined) {
                		    milestone.harvestProject = harvest_project;
                		}
            		} else {
                		/*console.log("Failed Teamwork Milestone: " + relationship.teamwork_milestone_id);
                		console.log("Failed Harvest Project: " + relationship.harvest_project_id);*/
            		}
        		});
        		vm.loadingHarvestTeamwork = false;
    		})
    		.error(function(response){
        		console.error(response);
    		});
		}
		
		function openTimeModal(harvest_project, milestone) {
    		var modalInstance = $uibModal.open({
        		animation: true,
        		templateUrl: "/js/angular/milestones/harvest/modals/time.html",
        		controller: "TimeModalController as mc",
        		resolve: {
            		parent_vm: function() {
                		return vm;
            		},
            		harvest_project: function() {
                		return harvest_project;
            		},
            		milestone: function() {
                		return milestone
            		}
        		}
    		});
    		
    		modalInstance.result.then(function(data){
        		Harvest.newEntry(data)
        		.success(function(response){
            		var data = response;
                    myWindow = window.open("data:text/html," + encodeURIComponent(data),
                       "_blank");
                    myWindow.focus();
        		})
        		.error(function(response){
            		console.error(response);
                });
    		});
		}
		
		// Reconcile a particular milestone to a particular Harvest project
		function connectHarvest(milestone) {
    		var modalInstance = $uibModal.open({
        		animation: true,
        		templateUrl: "/js/angular/milestones/harvest/modals/reconcile.html",
        		controller: "CreateTeamworkHarvestRelationshipModalController as mc",
        		resolve: {
            		teamwork_milestone: function() {
                		return milestone;
            		},
            		parent_vm: function() {
                		return vm;
            		}
        		}
    		});
    		
    		modalInstance.result.then(function(data){
				Harvest.addRelationship(data)
				.success(function(response){
					vm.getHarvestTeamwork();
				})
				.error(function(response){
					console.error(response);
				});
			});
		}
		
		function harvestButtons() {
      (function(){
        window._harvestPlatformConfig = {
        "applicationName": "Bureau Gravity Portal",
        "permalink": "https://portal.bureaugravity.com/milestones/",//%ITEM_ID%"
        "skipStyling": true
      };
      var s = document.createElement("script");
      s.src = "https://platform.harvestapp.com/assets/platform.js";
      s.async = false;
      var ph = document.getElementsByTagName("script")[0];
      ph.parentNode.insertBefore(s, ph);
      })();
		}
		
		// Copy to clipboard
		function copySuccess(e) {
			vm.copyPopup = "Copied!"
			$scope.$apply();
		}
		function copyError(e) {
			vm.copyPopup = "Command-C to copy"
			$scope.$apply();
		}
		function resetCopyPopup() {
			vm.copyPopup = "Click to Copy";
		}
		
		function warn(message) {
    		vm.warnings.push({message: message});
		}
		function dismissWarning(obj) {
    		vm.warnings = _.reject(vm.warnings, function(warning) {
        		return warning == obj;
    		});
		}
		
		// Search
		$scope.$watch('vm.search',function(nu,old){
			vm.visible_companies = _.filter(vm.companies,function(company){
				return company.name.toUpperCase().includes(vm.search.toUpperCase());
			});
			//harvestButtons();
		});
		
		// Visible Companies
		$scope.$watch('vm.visible_companies.length', function(nu,old) {
    		if (vm.visible_companies.length == 1) {
        		vm.visible_companies[0].isCollapsed = false;
    		} else {
        		_.each(vm.visible_companies,function(company){
            		company.isCollapsed = true;
        		});
    		}
		});
		
		/*
            The following code will take just the milestones and turn them into a companies array. The
            problem is that this user interface is supposed to allow for creation of milestones even
            under projects and companies that don't already have milestones, but creating the comapnies
            array this way would result in only the companies and projects being shown that already have
            milestones under them.
		*/
		/*
    		_.chain(milestones)
            .groupBy('company-name')
            .mapObject(function(val,key){
                return {
                    name: key,
                    projects: _.chain(val)
                                .groupBy('project-name')
                                .mapObject(function(vval,kkey){
                                    return {
                                        name: kkey,
                                        milestones: vval
                                    };
                                })
                                .values()
                                .value()
                };
            })
            .values()
            .value();
        */
	}
	
}();