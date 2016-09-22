!function() {
	
	angular.module('app')
	.factory('Website', ['$http', websiteFactory]);
	
	function websiteFactory($http) {
		
		var service = {
			get: getWebsites,
			create: createWebsite,
			update: updateWebsite,
			destroy: destroyWebsite,
			check: checkWebsite,
			uncheck: uncheckWebsite,
			days: getDays
		};
		
		return service;
		
		function getWebsites() {
			return $http.get('/api/website');
		}
		
		function updateWebsite(websiteData) {
			return $http.put('/api/website/' + websiteData.id, websiteData);
		}
		
		function createWebsite(websiteData) {
			return $http.post('/api/website', websiteData);
		}
		
		function destroyWebsite(id) {
			return $http.delete('/api/website/' + id);
		}
		
		function checkWebsite(id) {
			return $http.get('/api/website/' + id + '/check');
		}
		
		function uncheckWebsite(id) {
			return $http.get('/api/website/' + id + '/uncheck');
		}
		
		function getDays() {
			return $http.get('/api/website/days');
		}
		
	}
	
}();