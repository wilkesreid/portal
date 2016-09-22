!function() {
	
	angular.module('app')
	.controller('formController',['Form','$scope','$interval', '$timeout', formController])
	.directive('keepFocus', keepFocusDirective);
	
	function formController (Form, $scope, $interval, $timeout) {
		
		var vm = this;
		
		vm.loading = true;
		
		vm.id = window.form_id;
		vm.name = "";
		vm.hash = "";
		vm.fields = [];
		vm.sendUpdateTimer = $timeout(function() {
			//vm.sendUpdate();
		},500);
		vm.intervalPermitted = true;
		vm.updateInterval = $interval(function() {
			if (vm.intervalPermitted) {
				vm.update();
			}
		},500);
		vm.focusedElement = document.activeElement;
		
		vm.update = update;
		vm.sendUpdate = sendUpdate;
		vm.timeSendUpdate = timeSendUpdate;
		vm.blur = blur;
		vm.isTextType = isTextType;
		
		vm.update();
		
		function update() {
			vm.focusedElement = document.activeElement;
			Form.getById(vm.id)
			.success(function(response){
				vm.loading = false;
				
				if (vm.hash == response.hash) {
					return;
				}
				var response_data = JSON.parse(response.data);
				vm.name = response.name;
				vm.fields = response_data;
				vm.hash = response.hash;
				
			});
		}
		
		function sendUpdate() {
			$timeout.cancel(vm.sendUpdateTimer);
			
			var data = {
				name: vm.name,
				data: vm.fields
			};
			Form.update(vm.id, data)
			.success(function(response){
				vm.hash = response.hash;
				vm.intervalPermitted = true;
			});
		}
		
		function timeSendUpdate() {
			vm.intervalPermitted = false;
			$timeout.cancel(vm.sendUpdateTimer);
			vm.sendUpdateTimer = $timeout(function(){
				vm.sendUpdate();
			}, 0);
		}
		
		function blur($event) {
			var target = $event.target;
			target.blur();
		}
		
		function isTextType(field) {
			return (field.type == "text" || field.type == "email" || field.type == "number" || field.type == "tel");
		}
		
		/*$scope.$watch(function(){
			$scope.$$postDigest(function(){
				vm.focusedElement.focus();
			});
		});*/
		
	}
	
	function keepFocusDirective() {
		return {
			restrict: 'A',
			require: 'ngModel',
			priority: 1,
		    link: function(scope, element, attrs, ngModel) {
		    }
		};
	}
	
}();