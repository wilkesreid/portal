!function(){
	
	angular.module('app')
	
	.controller('deleteUserModalController', deleteUserModalController)
	.controller('deleteUserModalInstanceController', deleteUserModalInstanceController);
	
	function deleteUserModalController($uibModal) {
		var vm = this;
		vm.open = function(id,name) {
			var modalInstance = $uibModal.open({
				animation: true,
				templateUrl: 'confirmDeleteModal.html',
				controller: 'deleteUserModalInstanceController as iModal',
				resolve: {
					id: function() {
						return id;
					},
					name: function() {
						return name;
					}
				}
			});
		};
	}
	
	function deleteUserModalInstanceController($uibModalInstance, id, name) {
		var vm = this;
		vm.id = id;
		vm.name = name;
		vm.ok = function() {
			window.location.href = "/admin/users/delete/"+id;
		};
		vm.cancel = function() {
			$uibModalInstance.dismiss();
		};
	}
	
	
}();