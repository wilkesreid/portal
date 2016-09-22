!function() {
	
	angular.module('app')
	.controller('TacticTypeController', ['Tactic', '$uibModal', TacticTypeController]);
	
	function TacticTypeController(Tactic, $uibModal) {
		var vm = this;
		vm.TacticTypes = [];
		
		vm.newTacticTypeName = "";
		vm.oldTacticTypeName = "";
		
		vm.get = getTacticTypes;
		vm.create = createTacticType;
		vm.edit = editTacticType;
		vm.save = saveTacticType;
		vm.delete = deleteTacticType;
		vm.cancel = cancelTacticType;
		
		vm.loading = false;
		
		vm.get();
		
		function getTacticTypes() {
  		vm.loading = true;
			Tactic.getTacticTypes()
			.success(function(response){
				vm.TacticTypes = response;
				vm.loading = false;
			})
			.error(function(response){
				console.error(response);
			});
		}
		
		function createTacticType() {
			var data = {
				name: vm.newTacticTypeName
			};
			if (data.name == "") {
				return;
			}
			Tactic.createTacticType(data)
			.success(function(response){
				vm.get();
				vm.showCreateForm = false;
				vm.newTacticTypeName = "";
			})
			.error(function(response){
				console.error(response);
			});
		}
		
		function editTacticType(tactictype) {
    		tactictype.editing = true;
    		vm.oldTacticTypeName = tactictype.name;
		}
		
		function cancelTacticType(tactictype) {
  		tactictype.editing = false;
  		tactictype.name = vm.oldTacticTypeName;
		}
		
		function saveTacticType(tactictype) {
  		tactictype.editing = false;
  		var data = {
    		name: tactictype.name,
    		id: tactictype.id
  		};
  		Tactic.updateTacticType(tactictype.id, data)
  		.success(function(response){
    		vm.get();
  		})
  		.error(function(response){
    		console.error(response);
  		});
		}
		
		function deleteTacticType(tactictype) {
			var modalInstance = $uibModal.open({
				animation: true,
				templateUrl: '/js/angular/admin/tactic/modals/deleteTacticTypeModal.html',
				controller: 'DeleteTacticTypeModalInstanceController as deleteModalCtrl',
				resolve: {
					tactictype: function() {
						return tactictype;
					}
				}
			});
			
			modalInstance.result.then(function(tactictype){
				Tactic.destroyTacticType(tactictype.id)
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