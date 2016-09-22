!function(){
	
	angular.module('app')
	.controller('EditPlatformModalInstanceController', modalInstanceController);
	
	function modalInstanceController($uibModalInstance, Client, id, name, url, client_id) {
		var vm = this;
		
		vm.name = name;
		vm.url = url;
		vm.id = id;
		vm.clients = [];
		vm.client_id = client_id;
		
		getClients();
		
		vm.ok = ok;
		vm.cancel = cancel;
		
		function getClients() {
			Client.get()
			.success(function(response){
				vm.clients = response;
			})
			.error(function(response){
				console.log(response);
			});
		}
		
		function ok() {
			var data = {
				id: vm.id,
				name: vm.name,
				url: vm.url,
				client: vm.client_id
			};
			$uibModalInstance.close(data);
		}
		
		function cancel() {
			$uibModalInstance.dismiss();
		}
	}
	
}();