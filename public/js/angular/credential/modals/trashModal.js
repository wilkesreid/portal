!function(){
	
	angular.module('app')
	.controller('TrashedCredentialsModalInstanceController', modalInstanceController);
	
	function modalInstanceController(Credential, $uibModalInstance, $uibModal, trash) {
		var vm = this;
		
		vm.trash = trash;
		vm.permanent = true;
		
		vm.cancel = cancel;
		vm.delete = deleteCredential;
		vm.restore = restoreCredential;
		
		function cancel() {
			$uibModalInstance.close();
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
					for (i=0;i<vm.trash.length;i++) {
						if (vm.trash[i].id == id) {
							vm.trash.splice(i, 1);
						}
					}
				})
				.error(function(response){
					console.error(response);
				});
			});
		}
		
		function restoreCredential(id) {
			Credential.restore(id)
			.success(function(response){
				for (i=0;i<vm.trash.length;i++) {
					if (vm.trash[i].id == id) {
						vm.trash.splice(i, 1);
					}
				}
			})
			.error(function(response){
				console.error(response);
			});
		}
	}
	
}();