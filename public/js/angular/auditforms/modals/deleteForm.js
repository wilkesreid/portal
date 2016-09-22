!function() {
	
	angular.module('app')
	.controller('DeleteFormModalInstanceController',deleteFormModalInstanceController);
	
	function deleteFormModalInstanceController(Form, $uibModalInstance, id, name) {
		
		var mc = this;
		
		mc.id = id;
		mc.name = name;
		
		mc.ok = ok;
		mc.cancel = cancel;
		
		function ok() {
			$uibModalInstance.close(mc.id);
		}
		function cancel() {
			$uibModalInstance.dismiss();
		}
		
	}
	
}();