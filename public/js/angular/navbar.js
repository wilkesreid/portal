!function(){
	
	angular.module('app')
	
	.controller('NavbarController', NavbarController);
	
	function NavbarController() {
		var vm = this;
		vm.collapsed = true;
	}
	
}();