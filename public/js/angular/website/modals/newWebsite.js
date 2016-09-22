!function() {
	
	angular.module('app')
	.controller('NewWebsiteModalInstanceController',newWebsiteModalInstanceController);
	
	function newWebsiteModalInstanceController(Website, $uibModalInstance) {
		var vm = this;
		
		vm.name = "";
		vm.url = "";
		
		vm.ok = ok;
		vm.cancel = cancel;
		
		function ok() {
			var data = {
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