!function() {
	
	angular.module('app')
	.controller('DeleteClientModalInstanceController',deleteClientModalInstanceController);
	
	function deleteClientModalInstanceController(Client, $uibModalInstance, id, name) {
		
		var vm = this;
		
		vm.id = id;
		vm.name = name;
		vm.nameInput = "";
		
		vm.ok = ok;
		vm.cancel = cancel;
		
		function ok() {
			// As a security measure, require the user to type out
			// the name of the client he wants to delete. Helps
			// prevent accidental deletions
			if (vm.name == vm.nameInput) {
				$uibModalInstance.close(vm.id);
			}
		}
		function cancel() {
			$uibModalInstance.dismiss();
		}
		
	}
	
}();