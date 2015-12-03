!function() {
	
	angular.module('app')
	.factory('Platform', platformFactory);
	
	function platformFactory($http) {
		
		var service = {
			get: getPlatforms,
			delete: deletePlatform,
			create: createPlatform,
			update: updatePlatform,
			search: searchPlatforms,
			byName: getPlatformByName
		};
		
		return service;
		
		function getPlatforms(client_id) {
			return $http.get('/api/client/'+client_id+'/platform');
		}
		
		function deletePlatform(id) {
			return $http.delete('/api/client/'+client_id+'/platform/'+id);
		}
		
		function createPlatform(data) {
			return $http.post('/api/client/'+client_id+'/platform',data);
		}
		
		function updatePlatform(id, data) {
			return $http.put('/api/client/'+client_id+'/platform/'+id,data);
		}
		
		function searchPlatforms(val) {
			return $http.get('/api/platform/search/'+val);
		}
		
		function getPlatformByName(name) {
			return $http.get('/api/platform/'+name);
		}
		
	}
	
}();