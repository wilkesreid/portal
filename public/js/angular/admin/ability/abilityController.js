!function() {
	
	angular.module('app')
	.controller('AbilityController',abilityController);
	
	function abilityController(Ability) {
		var vm = this;
		vm.allAbilities = [
  		'do-admin-things',
  		'use-tools-menu',
			'view-passwords',
			'view-management-passwords',
			'edit-passwords',
			'edit-management-passwords',
			'view-websites',
			'edit-websites',
			'delete-websites',
			'edit-clients',
			'delete-clients',
			'edit-platforms',
			'delete-platforms',
			'security-menu',
			'edit-tactics',
			'create-milestone'
		];
		vm.abilities = [];
		vm.role = window.role;
		vm.showForm = false;
		vm.savedSuccess = false;
		
		vm.get = getAbilities;
		vm.save = save;
		vm.disableSuccess = disableSuccess;
		
		vm.get();
		
		function getAbilities() {
			Ability.get(vm.role)
			.success(function(response){
				vm.showForm = true;
				vm.abilities = response;
				console.log(response);
			})
			.error(function(response){
				console.log(response);
			});
		}
		
		function save() {
			var data = {
				abilities: vm.abilities
			};
			Ability.save(vm.role,data)
			.success(function(response){
				vm.get();
				vm.savedSuccess = true;
				setTimeout(vm.disableSuccess,1000);
			})
			.error(function(response){
				console.log(response);
			});
		}
		
		function disableSuccess() {
			vm.savedSuccess = false;
			
		}
		
		
	}
	
}();