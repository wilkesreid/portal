!function() {
	
	angular.module('app')
	.factory('Client', ['$http', clientFactory]);
	
	function clientFactory($http) {
		
		var service = {
			get: getClients,
			create: createClient,
			update: updateClient,
			destroy: destroyClient
		};
		
		return service;
		
		function getClients() {
			return $http.get('/api/client');
		}
		
		function updateClient(clientData) {
			return $http.put('/api/client/' + clientData.id, clientData);
		}
		
		function createClient(clientData) {
			return $http.post('/api/client', clientData);
		}
		
		function destroyClient(id) {
			return $http.delete('/api/client/' + id);
		}
		
	}
	
}();