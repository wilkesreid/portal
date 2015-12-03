!function(){
	
	angular.module('app', ['ui.bootstrap', 'ngclipboard'])
	
	.filter('dateToISO', function() {
	  return function(input) {
	    input = new Date(input).toISOString();
	    return input;
	  };
	});
	
}();