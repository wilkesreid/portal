!function(){
	
	angular.module('app')
	.controller('TrashedCredentialsModalInstanceController', modalInstanceController);
	
	function modalInstanceController(Credential, $uibModalInstance, $uibModal, platform_id) {
		var vm = this;
		
		vm.trash = {};
		vm.platform_id = platform_id;
		vm.permanent = true;
		vm.loading = true;
		
		vm.cancel = cancel;
		vm.delete = deleteCredential;
		vm.restore = restoreCredential;
		vm.getTrash = getTrash;
		
		vm.getTrash();
		
		function cancel() {
			$uibModalInstance.close();
		}
		
		function getTrash() {
			vm.loading = true;
			Credential.getTrash(vm.platform_id)
			.success(function(response){
				for (i=0;i<response.length;i++) {
					response[i].deleted_at = response[i].deleted_at.replace(" ","T");
				}
				vm.loading = false;
				vm.trash = response;
			})
			.error(function(response){
				console.error(response);
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
						return true;
					}
				}
			});
			
			modalInstance.result.then(function(id){
				Credential.delete(id)
				.success(function(response){
					vm.getTrash();
				})
				.error(function(response){
					console.error(response);
				});
			});
		}
		
		function restoreCredential(id) {
			Credential.restore(id)
			.success(function(response){
				vm.getTrash();
			})
			.error(function(response){
				console.error(response);
			});
		}
	}
	
}();