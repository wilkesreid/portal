!function() {
	
	angular.module('app')
	.controller('createFormController',['$scope','Form','$uibModal',createFormController]);
	
	function createFormController($scope, Form, $uibModal) {
		
		var vm = this;
		
		vm.name = "";
		vm.data = [];
		vm.newData = {
			name: "",
			type: "text",
			value: "",
			subfields: []
		};
		vm.fieldTypes = [
			"text",
			"label",
			"header",
			"separator",
			"email",
			"tel",
			"number",
			"checkbox"
		];
		vm.valid = false;
		
		vm.newField = newField;
		vm.insertNewField = insertNewField;
		vm.removeField = removeField;
		vm.submit = submit;
		vm.newSubfield = newSubfield;
		vm.removeSubField = removeSubField;
		vm.isTextType = isTextType;
		
		vm.newField();
		
		function newField() {
			vm.data.push(_.clone(vm.newData));
		}
		
		function insertNewField(index) {
			vm.data.splice(index+1, 0, _.clone(vm.newData));
		}
		
		function newSubfield(field) {
			var nu = _.clone(vm.newData);
			nu.subfields = [];
			field.subfields.push(nu);
		}

		function removeSubField(field,index) {
			field.subfields.splice(index,1);
		}
		
		function removeField(index) {
			vm.data.splice(index,1);
		}
		
		function submit() {
			vm.data = _.filter(vm.data,function(field){
				return field.name != "" && field.type != "";
			});
			var data = {
				name: vm.name,
				data: vm.data
			};
			Form.create(data)
			.success(function(response){
				window.location = "/forms";
			})
			.error(function(response){
				console.error(response);
			});
		}
		
		function isTextType(field) {
			return (field.type == "text" || field.type == "email" || field.type == "number" || field.type == "tel");
		}
		
		$scope.$watch('vm.name',function(old,nu) {
			vm.valid = vm.name != "";
		});
	}
	
}();