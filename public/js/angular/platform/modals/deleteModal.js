!function(){
	
	angular.module('app')
	.controller('DeletePlatformModalInstanceController', modalInstanceController);
	
	function modalInstanceController($uibModalInstance, id, name) {
		var vm = this;
		
		vm.name = name;
		vm.nameInput = "";
		vm.id = id;
		
		vm.ok = ok;
		vm.cancel = cancel;
		
		function ok() {
			if (vm.name == vm.nameInput) {
				$uibModalInstance.close(vm.id);
			}
		}
		
		function cancel() {
			$uibModalInstance.dismiss();
		}
	}
	
}();