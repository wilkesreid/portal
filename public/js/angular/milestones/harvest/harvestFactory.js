!function() {
	
	angular.module('app')
	.factory('Harvest', ['$http', harvestFactory]);
	
	function harvestFactory($http) {
		
		var service = {
    		
			getClients: getClients,
			
			getProjects: getProjects,
			
			getTasks: getTasks,
			
			getDaily: getDaily,
			
			getTeamwork: getTeamworkRelationships,
			
			addRelationship: addRelationship,
			
			newEntry: newEntry
		};
		
		return service;
		
		function getClients() {
			return $http.get('/api/harvest/client');
		}
		
		function getProjects() {
    		return $http.get('/api/harvest/project');
		}
		
		function getTasks() {
    		return $http.get('/api/harvest/task');
		}
		
		function getDaily() {
    		return $http.get('/api/harvest/daily');
		}
		
		function getTeamworkRelationships() {
    		return $http.get('/api/tw/harvest');
		}
		
		function addRelationship(data) {
    		return $http.post('/api/tw/harvest', data);
		}
		
		function newEntry(data) {
    		return $http.post('/api/harvest', data);
		}
	}
	
}();