csApp.directive('homepage', [function(){
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
				console.log("I'm here.");
				scope.$apply(function(){
					var valid = elem.val().length >= 4 && elem.val() === $(pass).val();
					console.log("valid"+valid);
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
