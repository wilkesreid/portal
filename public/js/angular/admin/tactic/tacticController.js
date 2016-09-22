!function() {
	
	angular.module('app')
	.controller('TacticController', ['Tactic', '$uibModal', tacticController]);
	
	function tacticController(Tactic, $uibModal) {
		var vm = this;
		vm.tactics = [];
		
		vm.newtacticName = "";
		vm.oldTacticname = "";
		vm.tactictype_id = window.tactictype_id;
		
		vm.get = getTactics;
		vm.create = createTactic;
		vm.edit = editTactic;
		vm.save = saveTactic;
		vm.delete = deleteTactic;
		vm.cancel = cancelTactic;
		
		vm.loading = false;
		
		vm.get();
		
		function getTactics() {
  		vm.loading = true;
			Tactic.getTactics(vm.tactictype_id)
			.success(function(response){
				vm.tactics = response;
				vm.loading = false;
			})
			.error(function(response){
				console.error(response);
			});
		}
		
		function createTactic() {
			var data = {
				name: vm.newtacticName,
				tactictype_id: vm.tactictype_id
			};
			if (data.name == "") {
				return;
			}
			Tactic.createTactic(data)
			.success(function(response){
				vm.get();
				vm.showCreateForm = false;
				vm.newtacticName = "";
			})
			.error(function(response){
				console.error(response);
			});
		}
		
		function editTactic(tactic) {
    		tactic.editing = true;
    		vm.oldTacticName = tactic.name;
		}
		
		function cancelTactic(tactic) {
  		tactic.editing = false;
  		tactic.name = vm.oldTacticName;
		}
		
		function saveTactic(tactic) {
  		tactic.editing = false;
  		var data = {
    		name: tactic.name,
    		id: tactic.id
  		};
  		Tactic.updateTactic(tactic.id, data)
  		.success(function(response){
    		vm.get();
  		})
  		.error(function(response){
    		console.error(response);
  		});
		}
		
		function deleteTactic(tactic) {
			var modalInstance = $uibModal.open({
				animation: true,
				templateUrl: '/js/angular/admin/tactic/modals/deleteTacticModal.html',
				controller: 'DeleteTacticModalInstanceController as deleteModalCtrl',
				resolve: {
					tactic: function() {
						return tactic;
					}
				}
			});
			
			modalInstance.result.then(function(tactic){
				Tactic.destroyTactic(tactic.id)
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