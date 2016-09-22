!function() {
	
	angular.module('app')
	.controller('formListController',['Form','$uibModal',formListController]);
	
	function formListController(Form, $uibModal) {
		
		var vm = this;
		
		vm.forms = [];
		vm.loading = false;
		
		vm.get = getForms;
		vm.delete = deleteForm;
		vm.duplicate = duplicateForm;
		
		vm.get();
		
		
		function getForms() {
			
			vm.loading = true;
			
			Form.get()
			.success(function(response){
				vm.forms = response;
				vm.loading = false;
			});
		}
				
		function deleteForm(id, name) {
			var modalInstance = $uibModal.open({
				animation: true,
				templateUrl: '/js/angular/forms/modals/confirmDeleteModal.html',
				controller: 'DeleteFormModalInstanceController as mc',
				resolve: {
					id: function() {
						return id;
					},
					name: function() {
						return name;
					}
				}
			});
			
			modalInstance.result.then(function(id){
				Form.destroy(id)
				.success(function(response){
					vm.get();
				})
				.error(function(response){
					console.error(response);
				});
			});
		}
		
		function duplicateForm(id) {
			Form.getById(id)
			.success(function(response){
				var form = response;
				form.data = JSON.parse(form.data);
				Form.create(form)
				.success(function(response){
					console.log(response);
					vm.get();
				});
			});
		}	
	}
	
}();