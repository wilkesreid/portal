!function(){
	
	angular.module('app')
	.controller('CreateCredentialModalInstanceController', modalInstanceController);
	
	function modalInstanceController($uibModalInstance) {
		var vm = this;
		
		vm.username = "";
		vm.password = "";
		vm.comments = "";
		
		vm.ok = ok;
		vm.cancel = cancel;
		
		function ok() {
			var data = {
				username: vm.username,
				password: vm.password,
				comments: vm.comments
			};
			$uibModalInstance.close(data);
		}
		
		function cancel() {
			$uibModalInstance.dismiss();
		}
	}
	
}();