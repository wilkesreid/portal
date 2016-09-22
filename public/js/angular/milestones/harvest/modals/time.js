!function() {
	
	angular.module('app')
	.controller('TimeModalController',
		['$scope', '$uibModalInstance', 'Harvest', 'parent_vm', 'harvest_project', 'milestone', timeModalController]);
	
	function timeModalController($scope, $uibModalInstance, Harvest, parent_vm, harvest_project, milestone) {
		var mc = this;
		
		mc.parent_vm = parent_vm;
		
		mc.loading = true;
		
		mc.harvest_project = harvest_project;
		mc.milestone = milestone;
		mc.daily = {};
		mc.view = "entries";
		mc.newEntry = {
    		description: "",
    		task_id: 0
		};
		mc.tasks = [];
		
		mc.cancel = cancel;
		mc.getDaily = getDaily;
		mc.startTimer = startTimer;
		mc.getTasks = getTasks;
		
		mc.getDaily();
		mc.getTasks();
		
		function startTimer() {
    		var data = {
        		project_id: mc.harvest_project,
        		milestone_id: mc.milestone,
        		description: mc.newEntry.description,
        		hours: -1
    		};
			$uibModalInstance.close(data);
		}
		
		function cancel() {
			$uibModalInstance.dismiss();
		}
		
		function getDaily() {
    		mc.loading = true;
    		Harvest.getDaily()
    		.success(function(response){
        		mc.daily = _.filter(response.day_entries,function(entry){
                    return entry.project_id == mc.harvest_project.id && entry.notes.startsWith(milestone.title.substring(0, milestone.title.length - 1));
            	});
        		mc.loading = false;
    		});
		}
		
		$scope.$watch('mc.daily', function(entries) {
    		entries = _.each(entries, function(entry) {
        		entry.hours = Math.floor(entry.hours) + ":" + pad((entry.hours * 60) % 60, 2);
    		});
		});
		
		function pad(n, width, z) {
          z = z || '0';
          n = n + '';
          return n.length >= width ? n : new Array(width - n.length + 1).join(z) + n;
        }
        
        function getTasks() {
            mc.loading = true;
            
            Harvest.getTasks()
            .success(function(response){
                mc.tasks = _.map(response,function(task){
                    task.billable = (task.billable_by_default ? "billable" : "");
                    return task.task;
                });
                console.log(mc.tasks);
                mc.loading = false;
            }) 
            .error(function(response){
                var data = response;
                myWindow = window.open("data:text/html," + encodeURIComponent(data),
                   "_blank", "height=200,width=200");
                myWindow.focus();
            });
        }
	}
	
}();