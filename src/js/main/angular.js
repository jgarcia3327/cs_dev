
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
	$scope.keyCheckLgn = function(event){
		$scope.logval.submitted=false;
		if(event.keyCode == 13){
			$scope.login($scope.logval);
		}
	}
	$scope.login = function(logval){
		if(!isValidEmail(logval.email)){
			logval.submitted = true;
		}
		else if(('pass' in logval) && (logval.pass).length < 4){
			logval.submitted = true;
		}
		else{
			logval.action = 'login';
			$http.post('php/process.php', $.param(logval), {headers: {'Content-Type':'application/x-www-form-urlencoded'}}).
			success(function (data) {
				if(data !== null && typeof data === 'object' && 'error' in data){
					logval.submitted = true;
				}
				else{
					location.reload();
				}
			}).error(function(data) {
				alert("Error contacting server. Please contact Dev CS.");
			});
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
			$http.post('php/process.php', $.param(regval), {headers: {'Content-Type':'application/x-www-form-urlencoded'}}).
			success(function (data) {
				if(data !== null && typeof data === 'object' && 'error' in data){
					if(data.error == 'Duplicate error.'){
						reghtml.css({'display':'block'});
						jQuery(".reg-loader").remove();
						regval.emailExist = true;
					}
				}
				else{
					location.reload();
				}
			}).error(function(data) {
				alert("Error contacting server. Please contact Dev CS.");
			});
		}
	}
}])
.factory('User', ['$http', function($http){
	var getUserData = function(){
		return $http.post('php/process.php', 'action=userData', {headers: {'Content-Type':'application/x-www-form-urlencoded'}}).
		success(function (data) {
			if(data !== null && typeof data === 'object' && 'error' in data){
				location.reload();
			}
			return data;
		}).error(function(data) {
			console.log("AJAX Fail");
		});
	};
	return {getUserData : getUserData};
}])
.controller('Dashboard', ['$scope', 'User', '$http', function($scope, User, $http){
	$scope.user = {};
	$scope.userEdit = {};
	$scope.userNew = {};
	//Get user data
	var  userData = User.getUserData();
	userData.then(function(result){
		$scope.user = result.data;
	});
	$scope.editUser = function(field){
		$scope.userEdit[field] = true;
		if(field=='name'){
			$scope.userNew['fname'] = $scope.user['fname'];
			$scope.userNew['lname'] = $scope.user['lname'];
		}
		else{
			$scope.userNew[field] = $scope.user[field];
		}
	}
	$scope.editCancel = function(field){
		$scope.userEdit[field] = false;
	}
	$scope.editUpdate = function(field){
		$scope.userEdit[field] = false;
		var arr = {};
		if(field=='name'){
			arr.db_table = 'user';
			if($scope.userNew['fname'] != $scope.user['fname']){
				//update fname
				$scope.user['fname'] = $scope.userNew['fname'];
				arr['fname'] = $scope.userNew['fname'];
			}
			if($scope.userNew['lname'] != $scope.user['lname']){
				//update lname
				$scope.user['lname'] = $scope.userNew['lname'];
				arr['lname'] = $scope.userNew['lname'];
			}
		}
		else if(field == 'team' || field == 'team_description'){
			arr.db_table = 'team';
			arr.tid = $scope.user.tid;
			$scope.user[field] = $scope.userNew[field];
			if(field == 'team'){
				arr['title'] = $scope.userNew[field];
			}
			if(field == 'team_description'){
				arr['description'] = $scope.userNew[field];
			}
		}
		else{
			arr.db_table = 'user';
			if($scope.userNew[field] != $scope.user[field]){
				//update field
				$scope.user[field] = $scope.userNew[field];
				arr[field] =  $scope.userNew[field];
			}
		}
		$scope.httpUpdate(arr);
	}
	$scope.httpUpdate = function(arr){
		if(arr !== null && typeof arr === 'object' && Object.keys(arr).length > 1){
			arr.action = 'update';
			$http.post('php/process.php', $.param(arr), {headers: {'Content-Type':'application/x-www-form-urlencoded'}}).
			success(function (data) {
				if(data !== null && typeof data === 'object' && 'error' in data){
					location.reload();
				}
			}).error(function(data) {
				alert("Error contacting server. Please contact Dev CS.");
			});
		}
	}
}])
.controller('Account', ['$scope', '$http', function($scope, $http){
	$scope.logout = function(){
		$http.post('php/process.php', 'action=logout', {headers: {'Content-Type':'application/x-www-form-urlencoded'}}).
			success(function (data) {
				location.reload();
			}).error(function(data) {
				alert("Error contacting server. Please contact Dev CS.");
			});
	}
}])

function primaryLoader(cls,msg){
	return '<span class="ajax-loader '+cls+'">'+msg+' <img src="img/blue-cube.gif" /></span>';
}

function isValidEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}