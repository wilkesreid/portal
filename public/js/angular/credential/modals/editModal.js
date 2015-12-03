!function(){
	
	angular.module('app')
	.controller('EditCredentialModalInstanceController', modalInstanceController);
	
	function modalInstanceController($uibModalInstance, id, username, password, comments) {
		var vm = this;
		
		vm.username = username;
		vm.password = password;
		vm.comments = comments;
		vm.id = id;
		
		vm.ok = ok;
		vm.cancel = cancel;
		
		function ok() {
			var data = {
				id: vm.id,
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