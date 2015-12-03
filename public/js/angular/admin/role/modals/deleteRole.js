!function() {
	
	angular.module('app')
	.controller('DeleteRoleModalInstanceController',deleteRoleModalInstanceController);
	
	function deleteRoleModalInstanceController(Role, $uibModalInstance, name) {
		
		var vm = this;
		vm.name = name;
		vm.nameInput = "";
		
		vm.ok = ok;
		vm.cancel = cancel;
		
		function ok() {
			// As a security measure, require the user to type out
			// the name of the client he wants to delete. Helps
			// prevent accidental deletions
			if (vm.name == vm.nameInput) {
				$uibModalInstance.close(vm.name);
			}
		}
		function cancel() {
			$uibModalInstance.dismiss();
		}
		
	}
	
}();