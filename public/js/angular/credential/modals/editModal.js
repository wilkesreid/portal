!function(){
	
	angular.module('app')
	.controller('EditCredentialModalInstanceController', modalInstanceController);
	
	function modalInstanceController($uibModalInstance, id, username, password, comments, type) {
		var vm = this;
		
		vm.username = username;
		vm.password = password;
		vm.comments = comments;
		vm.id = id;
		vm.type = type;
		
		vm.ok = ok;
		vm.cancel = cancel;
		
		function ok() {
			var data = {
				id: vm.id,
				username: vm.username,
				password: vm.password,
				comments: vm.comments,
				type: vm.type
			};
			$uibModalInstance.close(data);
		}
		
		function cancel() {
			$uibModalInstance.dismiss();
		}
	}
	
}();