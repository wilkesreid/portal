!function() {
	
	angular.module('app')
	.controller('DeleteTacticTypeModalInstanceController', deleteTacticTypeModalInstanceController);
	
	function deleteTacticTypeModalInstanceController(Tactic, $uibModalInstance, tactictype) {
		
		var mc = this;
		mc.tactictype = tactictype;
		
		mc.ok = ok;
		mc.cancel = cancel;
		
		function ok() {
			$uibModalInstance.close(mc.tactictype);
		}
		function cancel() {
			$uibModalInstance.dismiss();
		}
		
	}
	
}();