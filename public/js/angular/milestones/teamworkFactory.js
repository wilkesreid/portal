!function() {
	
	angular.module('app')
	.factory('Teamwork', ['$http', teamworkFactory]);
	
	function teamworkFactory($http) {
		
		var service = {
    		
			getMilestones: getMilestones,
			getAllMilestones: getAllMilestones,
			createMilestone: createMilestone,
			updateMilestone: updateMilestone,
			destroyMilestone: destroyMilestone,
			
			getProjects: getProjects,
			getAllProjects: getAllProjects,
			//createProject: createProject,
			//updateProject: updateProject,
			//destroyProject: destroyProject,
			
			getCompanies: getCompanies,
			//createCompany: createCompany,
			//updateCompany: updateCompany,
			//destroyCompany: destroyCompany,
			
			getPeople: getPeople
		};
		
		return service;
		
		function getMilestones(project_id) {
			return $http.get('/api/tw/project/'+project_id+'/milestone');
		}
		
		function getAllMilestones() {
    		return $http.get('/api/tw/milestone');
		}
		
		function updateMilestone(project_id, milestoneData) {
			return $http.put('/api/tw/milestone/' + milestoneData.id, milestoneData);
		}
		
		function createMilestone(milestoneData) {
			return $http.post('/api/tw/milestone', milestoneData);
		}
		
		function destroyMilestone(milestone_id) {
			return $http.delete('/api/tw/milestone/' + milestone_id);
		}
		
		function getProjects(company_id) {
    		return $http.get('/api/tw/company/'+company_id+'/project');
		}
		
		function getAllProjects() {
    		return $http.get('/api/tw/project');
		}
		
		function getCompanies() {
    		return $http.get('/api/tw/company');
		}
		
		function getPeople(project_id) {
    		return $http.get('/api/tw/project/'+project_id+'/people');
		}
	}
	
}();