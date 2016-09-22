!function() {
	
	angular.module('app')
	.controller('CreateFieldModalInstanceController',createFieldModalInstanceController);
	
	function createFieldModalInstanceController(Form, $scope, $uibModalInstance, fields) {
		
		var mc = this;
		
		mc.name = "";
		mc.value = "";
		mc.column_size = 12;
		mc.tag = "input:text";
		mc.attributes = {
    		"class": "form-control"
		};
		mc.options = [
    		{
        		name: "",
        		selected: false
    		}
		];
		mc.order = 0;
		mc.fields = fields;
		mc.addChoice = function() { mc.options.push({name:"",selected:false}); };
		mc.removeChoice = removeChoice;
		
		mc.ok = ok;
		mc.cancel = cancel;
		
		function ok() {
    		processTag();
    		var data = {
        		name: mc.name,
        		value: mc.value,
        		column_size: mc.column_size,
        		tag: mc.tag,
        		attributes: mc.attributes,
        		options: mc.options
    		}
			$uibModalInstance.close(data);
		}
		function cancel() {
			$uibModalInstance.dismiss();
		}
		
		function processTag() {
    		if (mc.tag.indexOf(":") > -1) {
        		var parts = mc.tag.split(":");
        		mc.tag = parts[0];
        		mc.attributes.type = parts[1];
    		} else if (mc.tag == 'choices') {
        		
    		}
		}
		
		function removeChoice(choice) {
            var index = _.indexOf(mc.options, choice);
            mc.options.splice(index, 1);
		}
		
		// Choices Templates
		$scope.$watch('mc.tag', function(value) {
    		if (value == 'input:text') {
        		mc.attributes.type = "text";
        		mc.attributes['class'] = "form-control";
    		} else
    		if (value == 'choices' && mc.attributes.type != "radio") {
        		mc.attributes.type = "checkbox";
    		} else
    		if (value == 'fou') {
        		mc.tag = 'choices';
        		var options = [
            		{
                		name: "Use Currently",
                		selected: false
            		},
            		{
                		name: "Never Used Before",
                		selected: false
            		},
            		{
                		name: "Used and Stopped",
                		selected: false
            		}
        		];
        		mc.options = options;
        		mc.attributes.type = "radio";
    		} else
    		if (value == 'hostattend') {
        		mc.tag = 'choices';
        		var options = [
            		{
                		name: "Host",
                		selected: false
            		},
            		{
                		name: "Attend",
                		selected: false
            		}
        		];
        		mc.options = options;
        		mc.attributes.type = "radio"
    		}
		});
	}
	
}();