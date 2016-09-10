
angular.module('devCS',[])
.directive('homepage', [function(){
	return {
		restrict: "E",
		templateUrl: "html/home.html"
	};	
}])
.directive('dashboard', [function(){
	return {
		restrict: "E",
		templateUrl: "html/dashboard.html"
	};
}])
.directive('copyright',[function(){
	var date = new Date;
	return{
		restrict: "E",
		template: "<span>"+date.getFullYear()+"</span>"
	};
}])
.directive('passCheck', [function(){
	return {
		require: 'ngModel',
		link: function(scope, elem, attrs, ctrl){
			var pass = "input[name='" + attrs.passCheck + "']";
			elem.add(pass).on('keyup', function(){
				scope.$apply(function(){
					var valid = elem.val().length >= 4 && elem.val() === $(pass).val();
					ctrl.$setValidity('passlen', $(pass).val().length >= 4);
					ctrl.$setValidity('passmatch', elem.val() === $(pass).val());
					ctrl.$setValidity('pass', valid);
				});
			});
		}
	}
}])
.controller('HomePage', ['$scope', '$http', function($scope, $http){
	$scope.regval = {};
	$scope.logval = {};
	$scope.action = true;
	$scope.toggleAction = function(){
		$scope.action = $scope.action==true? false : true;
	}
	$scope.login = function(logval){
		logval.submitted=false;
		if(!isValidEmail(logval.email)){
			logval.submitted = true;
		}
		else if(('pass' in logval) && (logval.pass).length < 4){
			logval.submitted = true;
		}
		else{
			logval.action = 'login';
			httpProcess($http, logval, true, false);
		}
	}
	$scope.register = function(valid, regval){
		regval.submitted = true;
		if(valid){
			var reghtml = jQuery('#view-reg div.intro-message');
			var tmp = reghtml.html();
			reghtml.before(primaryLoader('reg-loader',''));
			reghtml.css({'display':'none'});
			regval.action = 'register';
			httpProcess($http, regval, true, false);
		}
	}
	//HOMEPAGE KEYENTER
	$scope.keyEnterHome = function(func, param, event){
		if(event.keyCode == 13){
			func(param);
		}
	}
}])
.factory('User', ['$http', function($http){
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

/*
* @$skop = scope variable
* @orig = original values
* @tmp = temporay value for fiedl edit
* field = object__element pattern in String
*/
function fieldEditor($skop, orig, tmp, field){
	var e = field.substring(field.indexOf("__")+2);
	tmp[e] = orig[e];
	$skop[field] = true;
	$skop[field+"_invalid"] = false;
}

/*
* @$skop = angular scope variable
* @$http = angular http variable
* @orig = original values
* @tmp = temporay value for fiedl edit
* field = object__element pattern in String
* action = object data
*/
function fieldEditorUpdate($http, $skop, orig, tmp, field, action){
	console.log(field);
	//invalid input
	if($skop[field+'_invalid'] === true){
		return
	}
	var e = field.substring(field.indexOf("__")+2);
	//Clean leading and trailing spaces
	tmp[e] = $.trim(tmp[e]);
	//Empty new data entry
	if(tmp[e].length <= 0){
		$skop[field+'_invalid'] = true;
	}
	else{
		$skop[field+'invalid'] = false;
		$skop[field] = false;
		if(orig[e] !== tmp[e]){
			orig[e] = tmp[e];
			action[e] = tmp[e];
			//console.log(action);
			httpProcess($http, action, false, false);
		}
	}
}

/*
*@$http = ($http) http dependency
*@reqObj = (object) array post request
*@reload = (bool) reload page on success
*@retReq = (bool) return $http request function
*/
function httpProcess($http, reqObj, reload, retReq){
	//console.log(reqObj);
	if(reqObj !== null && typeof reqObj === 'object'){

		var httpRequest = $http.post('php/process.php', $.param(reqObj), {headers: {'Content-Type':'application/x-www-form-urlencoded'}}).
		success(function (data) {
			if(data !== null && typeof data === 'object' && 'error' in data){
				if(reqObj.action === 'login'){
					reqObj.submitted = true;
				}
				else if(reqObj.action === 'register'){
					if(data.error == 'Duplicate error.'){
						jQuery('#view-reg div.intro-message').css({'display':'block'});
						jQuery(".reg-loader").remove();
						reqObj.emailExist = true;
					}
				}
				else{
					location.reload();
				}
			}
			else if(reload){
				location.reload();
			}
			else{
				return data;
			}
			//console.log(data);
		}).error(function(data) {
			alert("Error contacting server. Please contact Dev CS.");
		});

		if(retReq){ //Return request function
			return httpRequest;
		}

	}
}

function primaryLoader(cls,msg){
	return '<span class="ajax-loader '+cls+'">'+msg+' <img src="img/blue-cube.gif" /></span>';
}

function isValidEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}