!function() {
	
	angular.module('app')
	.factory('Form', ['$http', formFactory]);
	
	function formFactory($http) {
		
		var service = {
			get: getForms,
			getById: getFormById,
			getFields: getFields,
			getDeletedFields: getDeletedFields,
			create: createForm,
			createField: createField,
			createFieldAfter: createFieldAfter,
			update: updateForm,
			updateField: updateFormField,
			destroy: destroyForm,
			destroyField: destroyField,
			restoreField: restoreField,
			frozen: getFreezeStatus,
			freeze: freeze,
			unfreeze, unfreeze,
			duplicate: duplicateForm
		};
		
		return service;
		
		function getForms() {
			return $http.get('/api/auditform');
		}
		
		function getFormById(id) {
			return $http.get('/api/auditform/' + id);
		}
		
		function getFields(id) {
    		return $http.get('/api/auditform/' + id + '/fields');
		}
		
		function getDeletedFields(id) {
    		return $http.get('/api/auditform/' + id + '/fields/deleted');
		}
		
		function updateForm(id, data) {
			return $http.put('/api/auditform/' + id, data);
		}
		
		function updateFormField(id, data) {
    		return $http.put('/api/auditform/field/' + id, data);
		}
		
		function createForm(data) {
			return $http.post('/api/auditform', data);
		}
		
		function createField(form_id, data) {
    		return $http.post('/api/auditform/' + form_id + '/field', data);
		}
		
		function createFieldAfter(form_id, data) {
    		return $http.post('/api/auditform/' + form_id + '/field/after/' + data.after_id, data);
		}
		
		function destroyForm(id) {
			return $http.delete('/api/auditform/' + id);
		}
		
		function destroyField(id) {
    		return $http.delete('/api/auditform/field/' + id);
		}
		
		function restoreField(id) {
    		return $http.get('/api/auditform/field/' + id + '/restore');
		}
		
		function getFreezeStatus(id) {
    		return $http.get('/api/auditform/' + id + '/frozen');
		}
		
		function freeze(id) {
    		return $http.put('/api/auditform/' + id + '/freeze');
		}
		
		function unfreeze(id) {
    		return $http.put('/api/auditform/' + id + '/unfreeze');
		}
		
		function duplicateForm(id) {
    		return $http.get('/api/auditform/' + id + '/duplicate');
		}
		
	}
	
}();