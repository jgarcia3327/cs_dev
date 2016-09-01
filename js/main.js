function primaryLoader(e,t){return'<span class="ajax-loader '+e+'">'+t+' <img src="img/blue-cube.gif" /></span>'}function isValidEmail(e){var t=/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;return t.test(e)}function isValidContactField(e,t){if("email"==t){var a=/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;return a.test(e)}return"length"==t&&e.length>0}angular.module("devCS",[]).directive("homepage",[function(){return{restrict:"E",templateUrl:"html/home.html"}}]).directive("dashboard",[function(){return{restrict:"E",templateUrl:"html/dashboard.html"}}]).directive("copyright",[function(){var e=new Date;return{restrict:"E",template:"<span>"+e.getFullYear()+"</span>"}}]).directive("passCheck",[function(){return{require:"ngModel",link:function(e,t,a,r){var n="input[name='"+a.passCheck+"']";t.add(n).on("keyup",function(){e.$apply(function(){var e=t.val().length>=4&&t.val()===$(n).val();r.$setValidity("passlen",$(n).val().length>=4),r.$setValidity("passmatch",t.val()===$(n).val()),r.$setValidity("pass",e)})})}}}]).controller("HomePage",["$scope","$http",function(e,t){e.regval={},e.logval={},e.action=!0,e.toggleAction=function(){e.action=1!=e.action},e.keyCheckLgn=function(t){e.logval.submitted=!1,13==t.keyCode&&e.login(e.logval)},e.login=function(e){isValidEmail(e.email)?"pass"in e&&e.pass.length<4?e.submitted=!0:(e.action="login",t.post("php/process.php",$.param(e),{headers:{"Content-Type":"application/x-www-form-urlencoded"}}).success(function(t){null!==t&&"object"==typeof t&&"error"in t?e.submitted=!0:location.reload()}).error(function(e){alert("Error contacting server. Please contact Dev CS.")})):e.submitted=!0},e.register=function(e,a){if(a.submitted=!0,e){var r=jQuery("#view-reg div.intro-message");r.html();r.before(primaryLoader("reg-loader","")),r.css({display:"none"}),a.action="register",t.post("php/process.php",$.param(a),{headers:{"Content-Type":"application/x-www-form-urlencoded"}}).success(function(e){null!==e&&"object"==typeof e&&"error"in e?"Duplicate error."==e.error&&(r.css({display:"block"}),jQuery(".reg-loader").remove(),a.emailExist=!0):location.reload()}).error(function(e){alert("Error contacting server. Please contact Dev CS.")})}}}]).factory("User",["$http",function(e){var t=function(){return e.post("php/process.php","action=userData",{headers:{"Content-Type":"application/x-www-form-urlencoded"}}).success(function(e){return null!==e&&"object"==typeof e&&"error"in e&&location.reload(),e}).error(function(e){console.log("AJAX Fail")})};return{getUserData:t}}]).controller("Dashboard",["$scope","User",function(e,t){e.user={},e.userEdit={},e.userNew={};var a=t.getUserData();a.then(function(t){e.user=t.data}),e.editUser=function(t){e.userEdit[t]=!0,e.userNew[t]=e.user[t]},e.editCancel=function(t){e.userEdit[t]=!1}}]).controller("Account",["$scope","$http",function(e,t){e.logout=function(){t.post("php/process.php","action=logout",{headers:{"Content-Type":"application/x-www-form-urlencoded"}}).success(function(e){location.reload()}).error(function(e){alert("Error contacting server. Please contact Dev CS.")})}}]),$(document).ready(function(){$("#contact-send-btn").click(function(){var e=$("input.contact-email"),t=$("textarea.contact-msg"),a=!0;$(".contact-email-container").removeClass("has-error"),isValidContactField(e.val(),"email")||($(".contact-email-container").addClass("has-error"),a=!1),$(".contact-msg-container").removeClass("has-error"),isValidContactField(t.val(),"length")||($(".contact-msg-container").addClass("has-error"),a=!1),a&&($(".contact-send").html("<img class='cs-loader-gif' src='img/ajax-loader.gif'/>"),$.ajax({type:"POST",url:"php/contact_form.php",data:{msg:t.val(),from:e.val()},success:function(a){console.log(a);var a=JSON.parse(a);1==a.result?(e.val(""),t.val(""),$(".contact-send").html("<p class='feedback-msg-success'>Thank you for sending us your message...</p>")):$(".contact-send").html("<p class='feedback-msg-error'>Something went wrong. Please refresh the page and send us your message again. Thank you.</p>")}}))})});