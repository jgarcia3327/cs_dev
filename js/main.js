function fieldEditor(t,e,a,r){var n=r.substring(r.indexOf("__")+2);a[n]=e[n],t[r]=!0,t[r+"_invalid"]=!1}function fieldEditorUpdate(t,e,a,r,n,i){if(console.log(n),e[n+"_invalid"]!==!0){var o=n.substring(n.indexOf("__")+2);r[o]=$.trim(r[o]),r[o].length<=0?e[n+"_invalid"]=!0:(e[n+"invalid"]=!1,e[n]=!1,a[o]!==r[o]&&(a[o]=r[o],i[o]=r[o],httpProcess(t,i,!1,!1)))}}function httpProcess(t,e,a,r){if(null!==e&&"object"==typeof e){var n=t.post("php/process.php",$.param(e),{headers:{"Content-Type":"application/x-www-form-urlencoded"}}).success(function(t){if(null!==t&&"object"==typeof t&&"error"in t)"login"===e.action?e.submitted=!0:"register"===e.action?"Duplicate error."==t.error&&(jQuery("#view-reg div.intro-message").css({display:"block"}),jQuery(".reg-loader").remove(),e.emailExist=!0):location.reload();else{if(!a)return t;location.reload()}}).error(function(t){alert("Error contacting server. Please contact Dev CS.")});if(r)return n}}function primaryLoader(t,e){return'<span class="ajax-loader '+t+'">'+e+' <img src="img/blue-cube.gif" /></span>'}function isValidEmail(t){var e=/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;return e.test(t)}function isValidContactField(t,e){if("email"==e){var a=/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;return a.test(t)}return"length"==e&&t.length>0}angular.module("devCS",[]).directive("homepage",[function(){return{restrict:"E",templateUrl:"html/home.html"}}]).directive("dashboard",[function(){return{restrict:"E",templateUrl:"html/dashboard.html"}}]).directive("copyright",[function(){var t=new Date;return{restrict:"E",template:"<span>"+t.getFullYear()+"</span>"}}]).directive("passCheck",[function(){return{require:"ngModel",link:function(t,e,a,r){var n="input[name='"+a.passCheck+"']";e.add(n).on("keyup",function(){t.$apply(function(){var t=e.val().length>=4&&e.val()===$(n).val();r.$setValidity("passlen",$(n).val().length>=4),r.$setValidity("passmatch",e.val()===$(n).val()),r.$setValidity("pass",t)})})}}}]).controller("HomePage",["$scope","$http",function(t,e){t.regval={},t.logval={},t.action=!0,t.toggleAction=function(){t.action=1!=t.action},t.login=function(t){t.submitted=!1,isValidEmail(t.email)?"pass"in t&&t.pass.length<4?t.submitted=!0:(t.action="login",httpProcess(e,t,!0,!1)):t.submitted=!0},t.register=function(t,a){if(a.submitted=!0,t){var r=jQuery("#view-reg div.intro-message");r.html();r.before(primaryLoader("reg-loader","")),r.css({display:"none"}),a.action="register",httpProcess(e,a,!0,!1)}},t.keyEnterHome=function(t,e,a){13==a.keyCode&&t(e)}}]).factory("User",["$http",function(t){var e=function(){return httpProcess(t,{action:"userData"},!1,!0)};return{getUserData:e}}]).factory("Project",["$http",function(t){var e=function(){return httpProcess(t,{action:"projectData"},!1,!0)};return{getProjectData:e}}]).controller("Dashboard",["$scope","User","Project","$http",function(t,e,a,r){t.user={},t.userEdit={},t.userNew={},t.projects=[],t.projectNew={};var n=e.getUserData();n.then(function(e){t.user=e.data});var i=a.getProjectData();i.then(function(e){t.projects=e.data}),t.addNewProject=function(e){if(null!==e&&"object"==typeof e&&"title"in e){var a={action:"addProject",title:e.title,tid:t.user.tid},n=httpProcess(r,a,!1,!0);n.then(function(e){t.projects.push(e.data)}),e.inValid=!1,e.title="",e.add=!1}else e.inValid=!0},t.editProject=function(e){t.activeProject=e},t.fieldEdit=function(e,a,r){fieldEditor(t,e,a,r)},t.fieldEditUpdate=function(e,a,n,i){fieldEditorUpdate(r,t,e,a,n,i)},t.fieldEditCancel=function(e){t[e]=!1},t.keyEnter=function(t,e,a){if(13==a.keyCode)if(e instanceof Array)switch(e.length){case 1:t(e[0]);break;case 2:t(e[0],e[1]);break;case 3:t(e[0],e[1],e[2]);break;case 4:t(e[0],e[1],e[2],e[3]);break;case 5:t(e[0],e[1],e[2],e[3],e[4]);break;case 6:t(e[0],e[1],e[2],e[3],e[4],e[5])}else t(e)}}]).controller("Account",["$scope","$http",function(t,e){t.logout=function(){httpProcess(e,{action:"logout"},!0,!1)}}]),$(document).ready(function(){$("#contact-send-btn").click(function(){var t=$("input.contact-email"),e=$("textarea.contact-msg"),a=!0;$(".contact-email-container").removeClass("has-error"),isValidContactField(t.val(),"email")||($(".contact-email-container").addClass("has-error"),a=!1),$(".contact-msg-container").removeClass("has-error"),isValidContactField(e.val(),"length")||($(".contact-msg-container").addClass("has-error"),a=!1),a&&($(".contact-send").html("<img class='cs-loader-gif' src='img/ajax-loader.gif'/>"),$.ajax({type:"POST",url:"php/contact_form.php",data:{msg:e.val(),from:t.val()},success:function(a){console.log(a);var a=JSON.parse(a);1==a.result?(t.val(""),e.val(""),$(".contact-send").html("<p class='feedback-msg-success'>Thank you for sending us your message...</p>")):$(".contact-send").html("<p class='feedback-msg-error'>Something went wrong. Please refresh the page and send us your message again. Thank you.</p>")}}))})});