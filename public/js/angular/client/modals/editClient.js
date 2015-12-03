!function() {
	
	angular.module('app')
	.controller('EditClientModalInstanceController',editClientModalInstanceController);
	
	function editClientModalInstanceController(Client, $uibModalInstance, id, name) {
		
		var vm = this;
		
		vm.id = id;
		vm.name = name;
		
		vm.ok = ok;
		vm.cancel = cancel;
		
		window.checkName = function() {
			return vm.name;
		}
		
		function ok() {
			var data = {
				id: vm.id,
				name: vm.name
			};
			$uibModalInstance.close(data);
		}
		function cancel() {
			$uibModalInstance.dismiss();
		}
		
	}
	
}();