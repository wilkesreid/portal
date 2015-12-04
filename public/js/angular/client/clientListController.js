!function() {
	
	angular.module('app')
	.controller('ClientListController',['Client','$uibModal',clientListController]);
	
	function clientListController(Client, $uibModal) {
		
		var vm = this;
		
		vm.clients = {};
		vm.loading = true;
		vm.editing = false;
		
		vm.get = getClients;
		vm.edit = editClient;
		vm.update = updateClient;
		vm.create = createClient;
		vm.delete = deleteClient;
		
		vm.get();
		
		
		function getClients() {
			
			vm.loading = true;
			
			Client.get()
			.success(function(response){
				for (i=0;i<response.length;i++) {
					if (response[i].name == "Internal") {
						response.splice(i,1);
					}
				}
				vm.clients = response;
				vm.loading = false;
			});
		}
		
		function updateClient(clientData) {
			
			Client.update(clientData)
			.success(function(response){
				vm.get();
			})
			.error(function(response){
				console.error(response);
			});
			
		}
		
		function editClient(id, name) {
			
			var modalInstance = $uibModal.open({
				animation: true,
				templateUrl: '/js/angular/client/modals/editClientModal.html',
				controller: 'EditClientModalInstanceController as editModalCtrl',
				resolve: {
					id: function() {
						return id;
					},
					name: function() {
						return name;
					}
				}
			});
			
			modalInstance.result.then(function(data){
				vm.update(data);
			});
			
		}
		
		function deleteClient(id, name) {
			var modalInstance = $uibModal.open({
				animation: true,
				templateUrl: '/js/angular/client/modals/confirmDeleteModal.html',
				controller: 'DeleteClientModalInstanceController as deleteModalCtrl',
				resolve: {
					id: function() {
						return id;
					},
					name: function() {
						return name;
					}
				}
			});
			
			modalInstance.result.then(function(id){
				Client.destroy(id)
				.success(function(response){
					vm.get();
				})
				.error(function(response){
					console.error(response);
				});
			});
		}
		
		function createClient() {
			var modalInstance = $uibModal.open({
				animation:true,
				templateUrl: '/js/angular/client/modals/createClientModal.html',
				controller: 'NewClientModalInstanceController as createModalCtrl'
			});
			
			modalInstance.result.then(function(data){
				Client.create(data)
				.success(function(response){
					vm.get();
				})
				.error(function(response){
					console.log(response);
				})
			});
		}
		
	}
	
}();