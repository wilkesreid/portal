!function(){
	
	angular.module('app')
	.controller('CredentialListController', credentialListController);
	
	function credentialListController(Credential, $uibModal) {
		var vm = this;
		
		vm.credentials = {};
		vm.trash = {};
		vm.platform_id = window.platform_id;
		vm.loading = true;
		
		vm.get		= getCredentials;
		vm.create	= createCredential;
		vm.edit		= editCredential;
		vm.getTrash	= getTrashedCredentials;
		vm.viewTrash = viewTrash;
		vm.delete	= deleteCredential;
		
		vm.get();
		vm.getTrash();
		
		function getCredentials() {
			vm.loading = true;
			Credential.get(vm.platform_id)
			.success(function(response){
				vm.loading = false;
				vm.credentials = response;
			})
			.error(function(response){
				console.error(response);
			});
		}
		
		function getTrashedCredentials() {
			Credential.getTrash(vm.platform_id)
			.success(function(response){
				vm.trash = response;
			})
			.error(function(response){
				console.error(response);
			});
		}
		
		function viewTrash() {
			var modalInstance = $uibModal.open({
				animation: true,
				templateUrl: '/js/angular/credential/modals/trashModal.html',
				controller: 'TrashedCredentialsModalInstanceController as modalCtrl',
				resolve: {
					platform_id: function() {
						return vm.platform_id;
					}
				}
			});
			
			modalInstance.result.then(function(){
				vm.get();
			});
		}
		
		function deleteCredential(id, username) {
			var modalInstance = $uibModal.open({
				animation: true,
				templateUrl: '/js/angular/credential/modals/deleteModal.html',
				controller: 'DeleteCredentialModalInstanceController as modalCtrl',
				resolve: {
					id: function() {
						return id;
					},
					username: function () {
						return username;
					},
					permanent: function() {
						return false;
					}
				}
			});
			
			modalInstance.result.then(function(id){
				Credential.delete(id)
				.success(function(response){
					vm.get();
					vm.getTrash();
				})
				.error(function(response){
					console.error(response);
				});
			});
		}
		
		function createCredential() {
			
			var modalInstance = $uibModal.open({
				animation: true,
				templateUrl: '/js/angular/credential/modals/createModal.html',
				controller: 'CreateCredentialModalInstanceController as modalCtrl'
			});
			
			modalInstance.result.then(function(data){
				data.platform_id = vm.platform_id;
				Credential.create(data)
				.success(function(response){
					vm.get();
				})
				.error(function(response){
					console.error(response);
				});
			});
			
		}
		
		function editCredential(id, username, password, comments) {
			
			var modalInstance = $uibModal.open({
				animation: true,
				templateUrl: '/js/angular/credential/modals/editModal.html',
				controller: 'EditCredentialModalInstanceController as modalCtrl',
				resolve: {
					id: function () {
						return id;
					},
					username: function(){
						return username;
					},
					password: function(){
						return password;
					},
					comments: function(){
						return comments;
					}
				}
			});
			
			modalInstance.result.then(function(data){
				Credential.update(data.id,data)
				.success(function(response){
					vm.get();
					vm.getTrash();
				})
				.error(function(response){
					console.error(response);
				});
			});
			
		}
	}
	
}();