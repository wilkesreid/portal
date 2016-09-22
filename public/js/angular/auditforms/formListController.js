!function() {
	
	angular.module('app')
	.controller('formListController',['Form','$uibModal',formListController]);
	
	function formListController(Form, $uibModal) {
		
		var vm = this;
		
		vm.forms = [];
		vm.loading = false;
		vm.creating_form = false;
		vm.newForm = {
    		name: ""
		};
		
		vm.get = getForms;
		vm.edit = editForm;
		vm.delete = deleteForm;
		vm.save = saveForm;
		vm.duplicate = duplicateForm;
		vm.create = createNewForm;
		vm.toggleCreateForm = toggleCreateForm;
		
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
				templateUrl: '/js/angular/auditforms/modals/confirmDeleteModal.html',
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
		
		function editForm(form) {
    		form.editing = true;
		}
		
		function saveForm(form) {
    		Form.update(form.id, form)
    		.success(function(response){
        		form.editing = false;
        		vm.get();
    		});
		}
		
		function duplicateForm(id) {
			Form.duplicate(id)
			.success(function(response){
				vm.get();
			})
			.error(function(response){
    			console.error(response);
            });
		}	
		
		function createNewForm() {
    		var data = _.clone(vm.newForm);
    		vm.newForm = {
        		name: ""
    		};
    		vm.creating_form = false;
    		Form.create(data)
    		.success(function(response){
        		vm.get();
    		});
		}
		
		function toggleCreateForm() {
    		vm.creating_form = !vm.creating_form;
		}
	}
	
}();