!function(){
	
	angular.module('app')
	.controller('CreatePlatformModalInstanceController', modalInstanceController);
	
	function modalInstanceController(Platform, $uibModalInstance) {
		var vm = this;
		
		vm.name = "";
		vm.url = "";
		
		vm.fromScratch = true;
		vm.copySelected = "";
		vm.platforms = [];
		
		vm.ok = ok;
		vm.cancel = cancel;
		vm.toggleFromScratch = toggleFromScratch;
		vm.getPlatforms = getPlatforms;
		vm.finishSearch = finishSearch;
		
		function ok() {
			var data = {
				name: vm.name,
				url: vm.url
			};
			$uibModalInstance.close(data);
		}
		
		function cancel() {
			$uibModalInstance.dismiss();
		}
		
		function toggleFromScratch() {
			vm.fromScratch = !vm.fromScratch;
		}
		
		function getPlatforms(val) {
			return Platform.search(val)
			.then(function(response){
				vm.platforms = response.data;
				return response.data.map(function(item){
					return item.name;
				});
			});
		}
		
		function finishSearch($item, $model, $label) {
			vm.fromScratch = true;
			var platform = grep(vm.platforms,function(e){ return e.name == vm.copySelected })[0];
			vm.name = platform.name;
			vm.url = platform.url;
			vm.copySelected = "";
		}
		
		// This function is a non-minified
		// version of $.grep from jQuery
		function grep(elems, callback, inv) {
		    var ret = [],
		        retVal;
		    inv = !!inv;
		
		    // Go through the array, only saving the items
		    // that pass the validator function
		    for (var i = 0, length = elems.length; i < length; i++) {
		        retVal = !!callback(elems[i], i);
		        if (inv !== retVal) {
		            ret.push(elems[i]);
		        }
		    }
		
		    return ret;
		}
	}
	
}();