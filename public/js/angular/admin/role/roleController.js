!function() {
	
	angular.module('app')
	.controller('RoleController',roleController);
	
	function roleController(Role, $uibModal) {
		var vm = this;
		vm.roles = {};
		
		// New Role
		vm.showCreateForm = false;
		vm.newRoleName = "";
		
		vm.get = getRoles;
		vm.create = createRole;
		vm.delete = deleteRole;
		
		vm.get();
		
		function getRoles() {
			Role.get()
			.success(function(response){
				vm.roles = response;
			})
			.error(function(response){
				console.log(response);
			});
		}
		
		function createRole() {
			var data = {
				name: vm.newRoleName
			};
			Role.create(data)
			.success(function(response){
				vm.get();
				vm.showCreateForm = false;
				vm.newRoleName = "";
			})
			.error(function(response){
				console.error(response);
			});
		}
		
		function deleteRole(name) {
			var modalInstance = $uibModal.open({
				animation: true,
				templateUrl: '/js/angular/admin/role/modals/deleteRoleModal.html',
				controller: 'DeleteRoleModalInstanceController as deleteModalCtrl',
				resolve: {
					name: function() {
						return name;
					}
				}
			});
			
			modalInstance.result.then(function(name){
				Role.delete(name)
				.success(function(response){
					vm.get();
				})
				.error(function(response){
					console.error(response)
				});
			});
		}
		
	}
	
}();