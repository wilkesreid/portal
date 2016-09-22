!function() {
    
    var app = angular.module('app');
	
	angular.module('app')
	.controller('formController',['Form','$uibModal','$scope','Upload', formController])
	.directive('bgAttributes', ['$compile', attributesDirective])
	.directive('boolean', ['$compile', booleanDirective])
	.directive('sectionHeading', ['$compile', sectionHeadingDirective])
	.directive('groupHeading', ['$compile', groupHeadingDirective])
	.directive('smallHeading', ['$compile', smallHeadingDirective])
	.directive('choices', ['$compile', choicesDirective]);
	
	function formController(Form, $uibModal, $scope, Upload) {
    	var vm = this;
    	
    	vm.fields = window.fields;
    	vm.form_id = window.form_id;
    	vm.loading = true;
    	vm.loadError = false;
    	vm.uuid = uuid.v4();
    	vm.frozen = window.form_frozen;
    	vm.frozen_text = vm.frozen ? "Unfreeze" : "Freeze";
    	vm.frozenLoaded = true;
    	vm.logged_in = window.logged_in;
    	vm.pubnub = PUBNUB.init({
            publish_key: 'pub-c-6785fe57-079f-4fb1-a0ba-433e64074234',
            subscribe_key: 'sub-c-45dd3fc6-3d48-11e6-85a4-0619f8945a4f',
            ssl: true
        });
        vm.deleteHistory = [];
    	
    	
    	vm.getFields = getFields;
    	vm.getDeletedFields = getDeletedFields;
    	vm.editForm = editForm;
    	vm.createField = createField;
    	vm.createFieldAfter = createFieldAfter;
    	vm.deleteField = deleteField;
    	vm.sendFieldChange = sendFieldChange;
    	vm.updateField = updateField;
    	vm.dumpField = dumpField;
    	vm.upload = uploadFile;
    	vm.toggleFrozen = toggleFrozen;
    	vm.equalizeRowHeights = equalizeRowHeights;
    	vm.restoreField = restoreField;
    	vm.undoDelete = undoDelete;
    	
    	vm.ctxMenu = [
        	['Edit', vm.editForm],
        	['Delete', vm.deleteField],
        	['Insert After', vm.createFieldAfter],
        	//['Log', vm.dumpField],
        	['Cancel', function(){}]
    	];
    	
    	vm.getFields();
    	vm.getDeletedFields();
    	
    	function getFields() {
        	vm.loading = true;
        	Form.getFields(form_id)
        	.success(function(response){
            	vm.fields = response;
            	vm.fields = orderLinkedList(vm.fields);
            	vm.loading = false;
        	})
        	.error(function(response){
            	console.error(response);
            	vm.loading = false;
            	vm.loadError = true;
            });
    	}
    	
    	function getDeletedFields() {
        	Form.getDeletedFields(form_id)
        	.success(function(response){
            	for (i=0;i<response.length;i++) {
                	vm.deleteHistory.push(response[i].id);
            	}
        	})
        	.error(function(response){
            	console.error(response);
            	vm.loadError = true;
        	});
    	}
    	
    	function createField() {
        	var modalInstance = $uibModal.open({
    			animation: true,
    			templateUrl: '/js/angular/auditforms/modals/createFieldModal.html',
    			controller: 'CreateFieldModalInstanceController as mc',
    			backdrop: 'static',
    			resolve: {
        			fields: function() {
            			return vm.fields;
        			}
    			}
    		});
    		
    		modalInstance.result.then(function(data){
    			Form.createField(vm.form_id, data)
    			.success(function(response){
    				vm.getFields();
    				var created_id = response.id;
    				vm.pubnub.publish({
                    	channel: vm.form_id,
                    	message: {
                        	uuid: vm.uuid,
                        	action: 'createField',
                        	id: created_id,
                        	value: data.value,
                        	name: data.name,
                        	column_size: data.column_size,
                        	tag: data.tag,
                        	attributes: data.attributes,
                        	options: data.options
                    	}
                	});
    			})
    			.error(function(response){
    				console.error(response);
    			})
    		});
    	}
    	
    	function createFieldAfter($itemScope) {
        	var modalInstance = $uibModal.open({
    			animation: true,
    			templateUrl: '/js/angular/auditforms/modals/createFieldModal.html',
    			controller: 'CreateFieldAfterModalInstanceController as mc',
    			backdrop: 'static',
    			resolve: {
        			fields: function() {
            			return vm.fields;
        			},
        			after_id: function() {
            			return $itemScope.field.id;
        			}
    			}
    		});
    		
    		modalInstance.result.then(function(data){
    			Form.createFieldAfter(vm.form_id, data)
    			.success(function(response){
    				vm.getFields();
    				var created_id = response.id;
    				vm.pubnub.publish({
                    	channel: vm.form_id,
                    	message: {
                        	uuid: vm.uuid,
                        	action: 'createField',
                        	id: created_id,
                        	value: data.value,
                        	name: data.name,
                        	column_size: data.column_size,
                        	tag: data.tag,
                        	attributes: data.attributes,
                        	options: data.options
                    	}
                	});
    			})
    			.error(function(response){
    				console.error(response);
    			})
    		});
    	}
    	
        function editForm($itemScope) {
        	var modalInstance = $uibModal.open({
    			animation: true,
    			templateUrl: '/js/angular/auditforms/modals/editFormModal.html',
    			controller: 'EditFormModalInstanceController as mc',
    			backdrop: 'static',
    			resolve: {
    				id: function() {
    					return $itemScope.field.id;
    				},
    				name: function() {
    					return $itemScope.field.name;
    				},
    				column_size: function() {
        				return $itemScope.field.column_size
    				},
    				value: function() {
        				return $itemScope.field.value;
    				},
    				tag: function() {
        				return $itemScope.field.tag;
    				},
    				attributes: function() {
        				return $itemScope.field.attributes;
    				},
    				options: function() {
        				return $itemScope.field.options;
    				}
    			}
    		});
    		
    		modalInstance.result.then(function(data){
        		vm.pubnub.publish({
                	channel: vm.form_id,
                	message: {
                    	uuid: vm.uuid,
                    	action: 'updateStructure',
                    	id: data.id,
                    	name: data.name,
                    	value: data.value,
                    	column_size: data.column_size,
                    	tag: data.tag,
                    	attributes: data.attributes,
                    	options: data.options
                	}
            	});
    			Form.updateField(data.id, data)
    			.success(function(response){
    				vm.getFields();
    			})
    			.error(function(response){
    				console.error(response);
    			})
    		});
    	}
    	
    	function deleteField($itemScope) {
        	Form.destroyField($itemScope.field.id)
        	.success(function(response){
            	vm.getFields();
            	vm.pubnub.publish({
                	channel: vm.form_id,
                	message: {
                    	uuid: vm.uuid,
                    	action: 'delete',
                    	id: $itemScope.field.id
                	}
            	});
            	vm.getDeletedFields();
            	//vm.deleteHistory.push($itemScope.field.id);
        	})
        	.error(function(response){
            	console.error(response);
            	vm.loadError = true;
            });
    	}
    	
    	function restoreField(id) {
        	Form.restoreField(id)
        	.success(function(response){
            	vm.getFields();
            	vm.pubnub.publish({
                	channel: vm.form_id,
                	message: {
                    	uuid: vm.uuid,
                    	action: 'restore'
                	}
            	});
            	vm.lastFieldDeleted = -1;
        	})
        	.error(function(response){
            	console.error(response);
            	cm.loadError = true;
        	});
    	}
    	
    	function undoDelete() {
        	vm.restoreField(vm.deleteHistory.pop());
    	}
    	
    	function updateField(field) {
        	var data = {
            	id: field.id,
            	value: field.value,
            	options: field.options
        	};
        	Form.updateField(field.id, data)
        	.success(function(response){
            	//console.log(response);
        	})
        	.error(function(response){
            	vm.loadError = true;
            	console.error(response);
            });
    	}
    	
    	function sendFieldChange(field) {
        	vm.pubnub.publish({
            	channel: vm.form_id,
            	message: {
                	uuid: vm.uuid,
                	action: 'update',
                	id: field.id,
                	value: field.value,
                	options: field.options
            	}
        	});
        	vm.updateField(field);
    	}
    	
    	function receiveFieldChange(message) {
        	if (message.uuid == vm.uuid) {
            	return;
        	}
        	switch (message.action) {
            	case "update":
            	    var i = _.findIndex(vm.fields, function(field) {
                	    return field.id == message.id;
            	    });
            	    vm.fields[i].value = message.value;
            	    vm.fields[i].options = message.options;
            	break;
            	case "updateStructure":
            	    var i = _.findIndex(vm.fields, function(field) {
                	    return field.id == message.id;
            	    });
            	    vm.fields[i].name = message.name;
            	    vm.fields[i].column_size = message.column_size;
            	    vm.fields[i].tag = message.tag;
            	    vm.fields[i].options = message.options;
            	    vm.fields[i].attributes = message.attributes;
            	break;
            	case "createField":
            	    /*vm.fields.push({
                	    id: message.id,
                	    value: message.value,
                	    name: message.name,
                	    column_size: message.column_size,
                	    tag: message.tag,
                	    attributes: message.attributes,
                	    value: ""
            	    });*/
            	    vm.getFields();
            	break;
            	case 'delete':
            	    vm.fields = _.reject(vm.fields, function(field) {
                	    return field.id == message.id;
            	    });
            	break;
            	case 'freeze':
            	    vm.frozen = true;
            	    if (vm.frozen) {
                        vm.frozen_text = "Unfreeze";
                    } else {
                        vm.frozen_text = "Freeze";
                    }
            	break;
                case 'unfreeze':
                    vm.frozen = false;
                    if (vm.frozen) {
                        vm.frozen_text = "Unfreeze";
                    } else {
                        vm.frozen_text = "Freeze";
                    }
                break;
                case 'restore':
                    vm.getFields();
                break;
        	}
        	$scope.$apply();
    	}
    	
    	vm.pubnub.subscribe({
            channel: vm.form_id,
            message: receiveFieldChange
        });
        
        function toggleFrozen() {
            vm.frozen = !vm.frozen;
            if (vm.frozen) {
                vm.frozen_text = "Unfreeze";
                Form.freeze(vm.form_id);
                vm.pubnub.publish({
                    channel: vm.form_id,
                    message: {
                    	uuid: vm.uuid,
                    	action: 'freeze'
                	}
                });
            } else {
                vm.frozen_text = "Freeze";
                Form.unfreeze(vm.form_id);
                vm.pubnub.publish({
                    channel: vm.form_id,
                    message: {
                	    uuid: vm.uuid,
                	    action: 'unfreeze'
                	}
                });
            }
        }
        
        function uploadFile(field) {
            var file = field.file;
            if (file) {
                field.value = "";
                
                file.upload = Upload.upload({
                    url: 'https://portal.bureaugravity.com/api/auditform/field/' + field.id + '/upload',
                    data: {
                        file: file,
                        name: file.name
                    }
                });
                file.upload.then(function (response) {
                    field.value = response.data.url;
                    vm.pubnub.publish({
                        channel: vm.form_id,
                        message: {
                            uuid: vm.uuid,
                            action: 'update',
                            id: field.id,
                            value: field.value,
                            options: field.options
                        }
                    });
                    file.progress = null;
                }, function(response) {
                    console.error(response.data);
                    vm.loadError = true;
                }, function(evt) {
                    file.progress = Math.min(100, parseInt(100.0 * evt.loaded / evt.total));
                });
            }
        }
        
        function equalizeRowHeights(element) {
            var arr = [];
            el = $(element).closest(".form-group");
            for (i=0;i<window.innerWidth;i++) {
              var k = document.elementFromPoint(i, el.offset().top - $(window).scrollTop());
              if (arr.indexOf(k) == -1 && $(k).hasClass("form-group")) {
                arr.push(k);
              }
            }
            var height = $(arr[0]).height();
            for (i=1;i<arr.length;i++) {
              $(arr[i]).css("height",height);
            }
        }
        
        function orderLinkedList(arr) {
            //return arr;
            var result = [];
            
            var i = 0;
            while (i != -1) {
                result.push(arr[i]);
                i = _.findIndex(arr, function(el) {
                    if (arr[i].order != null)
                    return el.id == arr[i].order;
                    else
                    return false;
                });
            }
            return result;
        }
        
        $scope.$on('elastic:resize', function(event, element, oldHeight, newHeight) {
            //vm.equalizeRowHeights(element);
        });
    	
    }
    
    function dumpField($itemScope) {
        console.log($itemScope.field);
    }
    
    function attributesDirective($compile) {
        return {
            restrict: 'A',
            link: function( scope, element, attrs ) {
                return scope.$watch(attrs.bgAttributes, function(attributes){
                    for (var attr in attributes) {
                        element.attr(attr, attributes[attr]);
                    }
                    $compile(element.contents())(scope);
                });
            }
        };
    }  
    
    function booleanDirective($compile) {
        return {
            restrict: 'E',
            scope: {
                ngModel: '=',
                ngDisabled: '='
            },
            templateUrl: '/js/angular/auditforms/templates/booleanTemplate.html',
            link: function( scope, element, attrs ) {
                
                $compile(element.contents())(scope);
            }
        };
    }
    
    function choicesDirective($compile) {
        return {
            restrict: 'E',
            scope: false,
            templateUrl: '/js/angular/auditforms/templates/choicesTemplate.html',
            link: function( scope, element, attrs) {
            }
        };
    }
    
    function sectionHeadingDirective($compile) {
        return {
            restrict: 'E',
            scope: {
                value: '=contents'
            },
            template: '<h2>{{value}}</h2>'
        };
    }
    
    function groupHeadingDirective($compile) {
        return {
            restrict: 'E',
            scope: {
                value: '=contents'
            },
            template: '<h3>{{ value }}</h3>'
        };
    }
    
    function smallHeadingDirective($compile) {
        return {
            restrict: 'E',
            scope: {
                value: '=contents'
            },
            template: '<h4>{{ value }}</h4>'
        };
    }
    
    
}();