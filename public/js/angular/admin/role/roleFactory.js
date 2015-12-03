!function(){

	angular.module('app')
	.factory('Role',roleFactory);
	
	function roleFactory($http){
		
		var service = {
			get: getRoles,
			create: createRole,
			delete: deleteRole
		};
		
		return service;
		
		function getRoles() {
			return $http.get('/api/role');
		}
		function createRole(data) {
			return $http.post('/api/role',data);
		}
		function deleteRole(id) {
			return $http.delete('/api/role/' + id);
		}
	}

}();