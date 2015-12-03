!function() {
	
	angular.module('app')
	.controller('NewClientModalInstanceController',newClientModalInstanceController);
	
	function newClientModalInstanceController(Client, $uibModalInstance) {
		var vm = this;
		
		vm.name = "";
		
		vm.ok = ok;
		vm.cancel = cancel;
		
		function ok() {
			var data = {
				name: vm.name
			};
			$uibModalInstance.close(data);
		}
		
		function cancel() {
			$uibModalInstance.dismiss();
		}
	}
	
}();