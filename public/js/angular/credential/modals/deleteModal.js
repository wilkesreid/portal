!function(){
	
	angular.module('app')
	.controller('DeleteCredentialModalInstanceController', modalInstanceController);
	
	function modalInstanceController($uibModalInstance, id, username, permanent) {
		var vm = this;
		
		vm.username = username;
		vm.id = id;
		vm.permanent = permanent;
		
		vm.ok = ok;
		vm.cancel = cancel;
		
		function ok() {
			$uibModalInstance.close(vm.id);
		}
		
		function cancel() {
			$uibModalInstance.dismiss();
		}
	}
	
}();