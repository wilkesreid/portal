!function(){

	angular.module('app')
	.factory('Ability',abilityFactory);
	
	function abilityFactory($http){
		
		var service = {
			get: getAbilities,
			save: save
		};
		
		return service;
		
		function getAbilities(role) {
			return $http.get('/api/ability/'+role);
		}
		function save(role,data) {
			return $http.post('/api/ability/'+role, data);
		}
	}

}();