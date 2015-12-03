!function() {
	
	angular.module('app')
	.factory('Credential', credentialFactory);
	
	function credentialFactory($http) {
		
		var service = {
			get: getCredentials,
			create: createCredential,
			update: updateCredential,
			getTrash: getTrashedCredentials,
			delete: deleteCredential,
			restore: restoreCredential
		};
		
		return service;
		
		function getCredentials(platform_id) {
			return $http.get('/api/platform/'+platform_id+'/credential');
		}
		
		function getTrashedCredentials(platform_id) {
			return $http.get('/api/platform/'+platform_id+'/credential/trash');
		}
		
		function deleteCredential(id) {
			return $http.delete('/api/credential/'+id);
		}
		
		function createCredential(data) {
			return $http.post('/api/platform/'+data.platform_id+'/credential',data);
		}
		
		function updateCredential(id, data) {
			return $http.put('/api/credential/'+id,data);
		}
		
		function restoreCredential(id) {
			return $http.get('/api/credential/'+id+'/restore');
		}
		
	}
	
}();