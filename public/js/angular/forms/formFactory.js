!function() {
	
	angular.module('app')
	.factory('Form', ['$http', formFactory]);
	
	function formFactory($http) {
		
		var service = {
			get: getForms,
			getById: getFormById,
			create: createForm,
			update: updateForm,
			destroy: destroyForm
		};
		
		return service;
		
		function getForms() {
			return $http.get('/api/form');
		}
		
		function getFormById(id) {
			return $http.get('/api/form/' + id);
		}
		
		function updateForm(id, data) {
			return $http.put('/api/form/' + id, data);
		}
		
		function createForm(data) {
			return $http.post('/api/form', data);
		}
		
		function destroyForm(id) {
			return $http.delete('/api/form/' + id);
		}
		
	}
	
}();