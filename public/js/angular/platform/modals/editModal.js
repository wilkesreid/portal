!function(){
	
	angular.module('app')
	.controller('EditPlatformModalInstanceController', modalInstanceController);
	
	function modalInstanceController($uibModalInstance, id, name, url) {
		var vm = this;
		
		vm.name = name;
		vm.url = url;
		vm.id = id;
		
		vm.ok = ok;
		vm.cancel = cancel;
		
		function ok() {
			var data = {
				id: vm.id,
				name: vm.name,
				url: vm.url
			};
			$uibModalInstance.close(data);
		}
		
		function cancel() {
			$uibModalInstance.dismiss();
		}
	}
	
}();