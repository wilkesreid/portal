!function(){
	
	angular.module('app')
	.controller('PlatformListController', platformListController);
	
	function platformListController(Platform, $uibModal) {
		var vm = this;
		
		vm.platforms = {};
		vm.client_id = window.client_id;
		
		vm.get		= getPlatforms;
		vm.delete	= deletePlatform;
		vm.create	= createPlatform;
		vm.edit		= editPlatform;
		vm.absUrl	= absoluteUrl;
		
		vm.get();
		
		function getPlatforms() {
			Platform.get(vm.client_id)
			.success(function(response){
				vm.platforms = response;
			})
			.error(function(response){
				console.error(response);
			});
		}
		
		function deletePlatform(id, name) {
			var modalInstance = $uibModal.open({
				animation: true,
				templateUrl: '/js/angular/platform/modals/deleteModal.html',
				controller: 'DeletePlatformModalInstanceController as modalCtrl',
				resolve: {
					id: function() {
						return id;
					},
					name: function () {
						return name;
					}
				}
			});
			
			modalInstance.result.then(function(id){
				Platform.delete(id)
				.success(function(response){
					vm.get();
				})
				.error(function(response){
					console.error(response);
				});
			});
		}
		
		function createPlatform() {
			
			var modalInstance = $uibModal.open({
				animation: true,
				templateUrl: '/js/angular/platform/modals/createModal.html',
				controller: 'CreatePlatformModalInstanceController as modalCtrl'
			});
			
			modalInstance.result.then(function(data){
				data.client_id = vm.client_id;
				Platform.create(data)
				.success(function(response){
					vm.get();
				})
				.error(function(response){
					console.error(response);
				});
			});
			
		}
		
		function editPlatform(id, name, url) {
			
			var modalInstance = $uibModal.open({
				animation: true,
				templateUrl: '/js/angular/platform/modals/editModal.html',
				controller: 'EditPlatformModalInstanceController as modalCtrl',
				resolve: {
					id: function () {
						return id;
					},
					name: function(){
						return name;
					},
					url: function(){
						return url;
					}
				}
			});
			
			modalInstance.result.then(function(data){
				Platform.update(data.id,data)
				.success(function(response){
					vm.get();
				})
				.error(function(response){
					console.error(response);
				});
			});
			
		}
		
		// The logic of this function was discovered
		// on StackOverflow and was written by Mark Byers
		// http://stackoverflow.com/questions/3543187/prepending-http-to-a-url-that-doesnt-already-contain-http
		function absoluteUrl(url) {
			if (!url.match(/^[a-zA-Z]+:\/\//))
			{
			    url = 'http://' + url;
			}
			return url;
		}
	}
	
}();