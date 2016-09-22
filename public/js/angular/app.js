!function(){
	
	angular.module('app', ['ui.bootstrap', 'ngclipboard', 'checklist-model', 'ui.bootstrap.contextMenu', 'monospaced.elastic', 'ui.slider', 'ngFileUpload'])
	
	.filter('substring', function() {
    	return function(str, start, end) {
    		return str.substring(start, end);
    	};
    })
	
	.filter('dateToISO', function() {
	  return function(input) {
	    input = new Date(input).toISOString();
	    return input;
	  };
	})
	
	.directive('onEnter', ['$parse', onEnter]);
	
	
	function onEnter($parse) {
	    return {
	    restrict: 'A',
	    compile: function($element, attr) {
	      var fn = $parse(attr.onEnter, null, true);
	      return function(scope, element) {
	        element.on("keydown keypress", function(event) {
	          if (event.which === 13) {
	            
	            // This will pass event where the expression used $event
	            fn(scope, { $event: event });
	            scope.$apply();
	            event.preventDefault();
	          }
	        });
	      };
	    }
	  };
	};
	
}();