!function() {
	
	angular.module('app')
	.controller('NewMilestoneModalInstanceController',
		['$scope', '$uibModalInstance', 'Tactic', 'Teamwork', 'parent_vm', newMilestoneModalInstanceController]);
	
	function newMilestoneModalInstanceController($scope, $uibModalInstance, Tactic, Teamwork, parent_vm) {
		var mc = this;
		
		mc.parent_vm = parent_vm;
		
		// Fields, in the order they appear in the modal
		mc.company = mc.parent_vm.companies[0];
		mc.project = {};
		mc.tacticType = {};
		mc.tactic = {};
		mc.duedate = "";
		mc.responsible_people = [];
		mc.people = [];
		mc.peopleLoading = false;
		mc.description = "";
		mc.datepopup = {
    		open: false
		};
		
		mc.fieldsValid = false;
		
		// Generated milestone name
		mc.name = "";
		mc.name_prefix = "";
		
		mc.loading = false;
		
		mc.ok = ok;
		mc.cancel = cancel;
		mc.getTactics = getTactics;
		mc.getTacticTypes = getTacticTypes;
		mc.autoselectProject = autoselectProject;
		mc.getPeople = getPeople;
		mc.datePopup = datePopup;
		
		mc.getTacticTypes();
		//mc.getTactics();
		//mc.getCompanyProjects();
		
		function ok() {
			var data = {
				company_id: mc.company.id,
				project_id: mc.project.id,
				tactic_name: mc.tactic.name,
				date_due: mc.duedate,
				responsible_people: _.map(mc.responsible_people,function(person){ return person.id }).toString(),
				description: mc.description
			};
			$uibModalInstance.close(data);
		}
		
		function cancel() {
			$uibModalInstance.dismiss();
		}
		
		function getTactics(tacticType) {
			mc.tactics = [];
			mc.loadingTactics = true;
			Tactic.getTactics(tacticType.id)
			.success(function(response){
				mc.tactics = response;
				mc.tactic = response[0];
				mc.loadingTactics = false;
			})
			.error(function(response){
    		    console.error(response);	
            });
		}
		
		function getTacticTypes() {
			Tactic.getTacticTypes()
			.success(function(response){
				mc.tacticTypes = response;
				mc.tacticType = response[0];
				mc.getTactics(mc.tacticType);
			});
		}
		
		function autoselectProject() {
    		if (mc.company.projects.length == 1) {
        		mc.project = mc.company.projects[0];
    		}
		}
		
		function getPeople(project_id) {
    		mc.peopleLoading = true;
    		Teamwork.getPeople(project_id)
    		.success(function(response){
        		mc.people = response.people;
        		_.map(mc.people,function(person){
            		person.name = person['first-name'] + " " + person['last-name'];
        		});
        		mc.peopleLoading = false;
    		})
    		.error(function(response){
                console.error(response);
            });
		}
		
		function datePopup() {
    		mc.datepopup.open = true;
		}
		
		$scope.$watch(['mc.description', 'mc.tactic'],function(nu, old){
    		if (_.isEmpty(mc.tactic)) {
        		mc.name = "";
        		mc.name_prefix = "";
    		} else {
        		mc.name = mc.tactic.name + "_" + mc.description;
        		mc.name_prefix = "–";
    		}
		});
		
		$scope.$watch('mc.project.id',function(nu,old) {
    		if (!_.isEmpty(mc.project)) {
    		    mc.getPeople(mc.project.id);
    		}
		});
		
		/*$scope.$watch('[mc.description,mc.company,mc.project,mc.responsible_people,mc.tacticType,mc.tactic,mc.duedate]',function(nu,old) {
    		if (mc.description != "" && !_.isEmpty(mc.company) && !_.isEmpty(mc.project) && mc.responsible_people.length > 0 && !_.isEmpty(mc.tacticType) && !_.isEmpty(mc.tactic) && mc.duedate != "") {
        		mc.fieldsValid = true;
    		} else {
        		mc.fieldsValid = false;
    		}
    		console.log(mc.fieldsValid);
		});*/
	}
	
}();