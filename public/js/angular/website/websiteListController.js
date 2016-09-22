!function() {
	
	angular.module('app')
	.controller('WebsiteListController',['Website','$uibModal',websiteListController]);
	
	function websiteListController(Website, $uibModal) {
		
		var vm = this;
		
		vm.websites = {};
		vm.loading = true;
		vm.editing = false;
		vm.check_days = 7;
		
		vm.get = getWebsites;
		//vm.edit = editWebsite;
		vm.update = updateWebsite;
		vm.markChecked = markWebsiteChecked;
		vm.uncheck = markNotChecked;
		vm.create = createWebsite;
		vm.hasBeenChecked = hasBeenChecked;
		//vm.delete = deleteWebsite;
		vm.absUrl = absoluteUrl;
		
		vm.get();
		
		
		function getWebsites() {
			
			vm.loading = true;
			
			Website.days().success(function(response){
				vm.check_days = response;
			
				Website.get()
				.success(function(response){
					vm.websites = response;
					vm.loading = false;
					for (i=0;i<vm.websites.length;i++) {
						vm.websites[i].checked = vm.hasBeenChecked(vm.websites[i].checked_last);
						var malware_responses = ["malware","phishing","unwanted","phishing,malware","phishing,unwanted","malware,unwanted","phishing,malware,unwanted"];
						vm.websites[i].malware = (malware_responses.indexOf(vm.websites[i].malware) != -1);
						console.log('malware – ' + vm.websites[i].url+": "+vm.websites[i].malware);
						console.log('pixel – ' + vm.websites[i].url+": "+vm.websites[i].pixel);
					}
				});
			
			});
		}
		
		function markWebsiteChecked(website_id) {
			Website.check(website_id)
			.success(function(response){
				vm.get();
			})
			.error(function(response){
				console.error(response);
			});
		}
		function markNotChecked(website_id) {
			Website.uncheck(website_id)
			.success(function(response){
				vm.get();
			})
			.error(function(response){
				console.error(response);
			});
		}
		
		function updateWebsite(websiteData) {
			
			Website.update(websiteData)
			.success(function(response){
				vm.get();
			})
			.error(function(response){
				console.error(response);
			});
			
		}
		
		/*function editWebsite(id, name) {
			
			var modalInstance = $uibModal.open({
				animation: true,
				templateUrl: '/js/angular/website/modals/editWebsiteModal.html',
				controller: 'EditWebsiteModalInstanceController as editModalCtrl',
				resolve: {
					id: function() {
						return id;
					},
					name: function() {
						return name;
					}
				}
			});
			
			modalInstance.result.then(function(data){
				vm.update(data);
			});
			
		}*/
		
		/*function deleteWebsite(id, name) {
			var modalInstance = $uibModal.open({
				animation: true,
				templateUrl: '/js/angular/website/modals/confirmDeleteModal.html',
				controller: 'DeleteWebsiteModalInstanceController as deleteModalCtrl',
				resolve: {
					id: function() {
						return id;
					},
					name: function() {
						return name;
					}
				}
			});
			
			modalInstance.result.then(function(id){
				Website.destroy(id)
				.success(function(response){
					vm.get();
				})
				.error(function(response){
					console.error(response);
				});
			});
		}*/
		
		function createWebsite() {
			var modalInstance = $uibModal.open({
				animation:true,
				templateUrl: '/js/angular/website/modals/createWebsiteModal.html',
				controller: 'NewWebsiteModalInstanceController as createModalCtrl'
			});
			
			modalInstance.result.then(function(data){
				Website.create(data)
				.success(function(response){
					vm.get();
				})
				.error(function(response){
					console.log(response);
				})
			});
		}
		
		function hasBeenChecked(date_checked) {
			var today = new Date();
			var oneweekago = Date.parse(new Date(today.getFullYear(), today.getMonth(), today.getDate() - vm.check_days));
			date_checked = new Date(date_checked);
			
			if (date_checked > oneweekago) {
				return true;
			}
			return false;
		}
		
		// The logic of this function was discovered
		// on StackOverflow and was written by Mark Byers
		// http://stackoverflow.com/questions/3543187/prepending-http-to-a-url-that-doesnt-already-contain-http
		function absoluteUrl(url) {
			if (!url.match(/^[a-zA-Z]+:\/\//))
			{
			    url = 'http://' + url;
			}
			return url;
		}
		
	}
	
}();