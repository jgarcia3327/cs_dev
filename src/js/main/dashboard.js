csApp.factory('User', ['$http', function($http){
	var getUserData = function(){
		return httpProcess($http, {'action':'userData'}, false, true);
	}
	return {getUserData : getUserData};
}])
.factory('Project', ['$http', function($http){
	var getProjectData = function(){
		return httpProcess($http, {'action':'projectData'}, false, true);
	}
	return {getProjectData : getProjectData};
}])
.controller('Dashboard', ['$scope', 'User', 'Project', '$http', function($scope, User, Project, $http){
	//USER INFO
	$scope.user = {};
	$scope.userEdit = {};
	$scope.userNew = {};
	$scope.projects = [];
	$scope.projectNew = {};
	//Get user data
	var  userData = User.getUserData();
	userData.then(function(result){
		$scope.user = result.data;
	});
	//Get project data
	var  projectData = Project.getProjectData();
	projectData.then(function(result){
		$scope.projects = result.data;
	});
	//ADD PROJECT
	$scope.addNewProject = function(newProject){
		if(newProject !== null && typeof newProject === 'object' && 'title' in newProject){
			var addProject = {'action':'addProject', 'title':newProject.title, 'tid':$scope.user.tid};
			var responseProj = httpProcess($http, addProject, false, true);
			responseProj.then(function(result){
				$scope.projects.push(result.data);
			});
			newProject.inValid = false;
			newProject.title = "";
			newProject.add = false;
		}
		else{
			newProject.inValid = true;
		}
	}
	//SELECT PROJECT
	$scope.editProject = function(selProject){
		$scope.activeProject = selProject;
	}
	//DASHBOARD GENERAL EDITOR
	$scope.fieldEdit = function(orig, tmp, field){
		fieldEditor($scope, orig, tmp, field);
	}
	$scope.fieldEditUpdate = function(orig, tmp, field, action){
		fieldEditorUpdate($http, $scope, orig, tmp, field, action);
	}
	$scope.fieldEditCancel = function(field){
		$scope[field] = false;
	}
	//DASHBOARD KEYENTER
	$scope.keyEnter = function(func, param, event){
		if(event.keyCode == 13){
			if(param instanceof Array){
				switch(param.length){
					case 1 : func(param[0]); break;
					case 2 : func(param[0], param[1]); break;
					case 3 : func(param[0], param[1], param[2]); break;
					case 4 : func(param[0], param[1], param[2], param[3]); break;
					case 5 : func(param[0], param[1], param[2], param[3], param[4]); break;
					case 6 : func(param[0], param[1], param[2], param[3], param[4], param[5]); break;
				}
			}
			else{
				func(param);
			}
		}
	}
}])
.controller('Account', ['$scope', '$http', function($scope, $http){
	$scope.logout = function(){
		httpProcess($http, {'action':'logout'}, true, false);
	}
}])