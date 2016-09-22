!function() {
	
	angular.module('app')
	.controller('editFormController', ['Form', '$scope', '$uibModal', editFormController]);
	
	
	function editFormController(Form, $scope, $uibModal) {
    	var editvm = this;
    	
    	editvm.name = "";
    	
    	editvm.editForm = editForm;
    	
    	editvm.ctxMenu = [
        	['Edit', editvm.editForm]
    	];
    	
    	function editForm($itemScope) {
        	var modalInstance = $uibModal.open({
				animation: true,
				templateUrl: '/js/angular/auditforms/modals/editFormModal.html',
				controller: 'EditFormModalInstanceController as mc',
				resolve: {
					id: function() {
						return $itemScope.field.id;
					},
					name: function() {
						return $itemScope.field.name;
					}
				}
			});
			
			modalInstance.result.then(function(data){
				Form.updateField(data.id, data)
				.success(function(response){
					
				})
				.error(function(response){
					console.log(response);
				})
			});
    	}
	}
    
}();