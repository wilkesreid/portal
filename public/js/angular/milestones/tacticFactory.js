!function() {
	
	angular.module('app')
	.factory('Tactic', ['$http', tacticFactory]);
	
	function tacticFactory($http) {
		
		var service = {
    		
			getTacticTypes: getTacticTypes,
			createTacticType: createTacticType,
			updateTacticType: updateTacticType,
			destroyTacticType: destroyTacticType,
			
			getTactics: getTactics,
			updateTactic: updateTactic,
			createTactic: createTactic,
			destroyTactic: destroyTactic,
		};
		
		return service;
		
		// Tactic Types
		function getTacticTypes() {
			return $http.get('/api/tactictype');
		}
		
		function updateTacticType(tactictype_id, tactictypeData) {
			return $http.put('/api/tactictype/' + tactictype_id, tactictypeData);
		}
		
		function createTacticType(tactictypeData) {
			return $http.post('/api/tactictype', tactictypeData);
		}
		
		function destroyTacticType(tactictype_id) {
			return $http.delete('/api/tactictype/' + tactictype_id);
		}
		
		// Tactics
		function getTactics(tactictype_id) {
    		return $http.get('/api/tactictype/'+tactictype_id+'/tactic');
		}
		function updateTactic(tactic_id, tactic_data) {
      return $http.put('/api/tactic/'+tactic_id, tactic_data);
		}
		function createTactic(tactic_data) {
  		return $http.post('/api/tactic', tactic_data);
		}
		function destroyTactic(tactic_id) {
  		return $http.delete('/api/tactic/'+tactic_id);
		}
		
	}
	
}();