!function() {
	
	angular.module('app')
	.controller('DeleteTacticModalInstanceController', deleteTacticModalInstanceController);
	
	function deleteTacticModalInstanceController(Tactic, $uibModalInstance, tactic) {
		
		var mc = this;
		mc.tactic = tactic;
		
		mc.ok = ok;
		mc.cancel = cancel;
		
		function ok() {
			$uibModalInstance.close(mc.tactic);
		}
		function cancel() {
			$uibModalInstance.dismiss();
		}
		
	}
	
}();