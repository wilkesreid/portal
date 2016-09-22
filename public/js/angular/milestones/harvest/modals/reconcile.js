!function() {
	
	angular.module('app')
	.controller('CreateTeamworkHarvestRelationshipModalController',
		['$scope', '$uibModalInstance', 'Harvest', 'teamwork_milestone', 'parent_vm', createTeamworkHarvestRelationshipModalController]);
	
	function createTeamworkHarvestRelationshipModalController($scope, $uibModalInstance, Harvest, teamwork_milestone, parent_vm) {
		var mc = this;
		
		mc.parent_vm = parent_vm;
		
		mc.fieldsValid = false;
		
		mc.teamwork_milestone = teamwork_milestone;
		mc.harvest_project = {};
		
		mc.ok = ok;
		mc.cancel = cancel;
		
		function ok() {
			var data = {
				teamwork_milestone_id: mc.teamwork_milestone.id,
				harvest_project_id: mc.harvest_project.id
			};
			$uibModalInstance.close(data);
		}
		
		function cancel() {
			$uibModalInstance.dismiss();
		}
		
		$scope.$watch('mc.harvest_project', function(nu,old) {
    		mc.fieldsValid = !_.isEmpty(mc.harvest_project);
		});
	}
	
}();