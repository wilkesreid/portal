!function() {
	
	angular.module('app')
	.controller('editFormController',['$scope','Form','$uibModal',editFormController]);
	
	function editFormController($scope, Form, $uibModal) {
		
		var vm = this;
		
		vm.id = window.form_id;
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
			"textarea",
			"label",
			"header",
			"separator",
			"email",
			"tel",
			"number",
			"checkbox"
		];
		vm.valid = false;
		vm.loading = true;
		
		vm.newField = newField;
		vm.insertNewField = insertNewField;
		vm.removeField = removeField;
		vm.submit = submit;
		vm.get = getForm;
		vm.isTextType = isTextType;
		vm.newSubfield = newSubfield;
		vm.removeSubField = removeSubField;
		
		vm.get();
		
		function newField() {
			vm.data.push(_.clone(vm.newData));
		}
		
		function insertNewField(index) {
			vm.data.splice(index+1, 0, _.clone(vm.newData));
		}
		
		function newSubfield(index) {
			var nu = _.clone(vm.newData);
			nu.subfields = [];
			vm.data[index].subfields.push(nu);
		}
		
		function removeField(index) {
			vm.data.splice(index,1);
		}
		
		function removeSubField(field,index) {
			field.subfields.splice(index,1);
		}
		
		function getForm() {
			Form.getById(vm.id)
			.success(function(response){
				vm.name = response.name;
				vm.data = JSON.parse(response.data);
				vm.loading = false;
			});
		}
		
		function submit() {
			vm.data = _.filter(vm.data,function(field){
				return (field.name != "" && field.type != "") || field.type == "separator";
			});
			var data = {
				name: vm.name,
				data: vm.data
			};
			Form.update(vm.id, data)
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