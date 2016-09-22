!function() {
	
	angular.module('app')
	.controller('EditFormModalInstanceController',editFormModalInstanceController);
	
	function editFormModalInstanceController(Form, $uibModalInstance, $scope, id, name, value, column_size, tag, attributes, options) {
		
		var mc = this;
		
		mc.id = id;
		mc.name = name;
		mc.value = value;
		mc.column_size = column_size;
		mc.tag = tag;
		mc.attributes = attributes;
		mc.options = options;
		
		if (mc.tag == "input" && mc.attributes.type == "text") {
    		mc.tag = "input:text";
    		delete mc.attributes.type;
		}
		
		mc.ok = ok;
		mc.cancel = cancel;
		mc.removeChoice = removeChoice;
		mc.addChoice = function() { mc.options.push({name:"",selected:false}); };
		
		function ok() {
    		processTag();
    		var data = {
        		id: mc.id,
        		name: mc.name,
        		column_size: mc.column_size,
        		value: mc.value,
        		tag: mc.tag,
        		attributes: mc.attributes,
        		options: mc.options
    		};
			$uibModalInstance.close(data);
		}
		function cancel() {
    		processTag();
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
    		if (value == 'choices' && mc.attributes.type != "radio") {
                mc.attributes.type = 'checkbox';
    		} else
    		if (value == 'input:text') {
        		mc.attributes.type = 'text';
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