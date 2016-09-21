function fieldEditor(e,t,a,n){var r=n.substring(n.indexOf("__")+2);a[r]=t[r],e[n]=!0,e[n+"_invalid"]=!1}function fieldEditorUpdate(e,t,a,n,r,i){if(t[r+"_invalid"]!==!0){console.log(r);var o=r.substring(r.indexOf("__")+2);if(n[o]=$.trim(n[o]),n[o].length<=0)t[r+"_invalid"]=!0;else if(a[o]!==n[o]){a[o]=n[o],i[o]=n[o],console.log(i);var s=httpProcess(e,i,!1,!0);s.then(function(e){console.log(e.data);var a=e.data;null!==a&&"object"==typeof a&&"error"in a?(console.log("Encounter error on update."),t[r+"_invalid"]=!0):(console.log("Update Successful"),t[r+"invalid"]=!1,t[r]=!1)})}}}function httpProcess(e,t,a,n){if(null!==t&&"object"==typeof t){var r=e.post("php/process.php",$.param(t),{headers:{"Content-Type":"application/x-www-form-urlencoded"}}).success(function(e){if(null!==e&&"object"==typeof e&&"error"in e)if("login"===t.action)t.submitted=!0;else if("register"===t.action)"Duplicate error."==e.error&&(jQuery("#view-reg div.intro-message").css({display:"block"}),jQuery(".reg-loader").remove(),t.emailExist=!0);else{if(!a)return e;location.reload()}else{if(!a)return e;location.reload()}}).error(function(e){alert("Error contacting server. Please contact Dev CS.")});if(n)return r}}function primaryLoader(e,t){return'<span class="ajax-loader '+e+'">'+t+' <img src="img/blue-cube.gif" /></span>'}function isValidEmail(e){var t=/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;return t.test(e)}function isValidContactField(e,t){if("email"==t){var a=/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;return a.test(e)}return"length"==t&&e.length>0}csApp.factory("User",["$http",function(e){var t=function(){return httpProcess(e,{action:"userData"},!1,!0)};return{getUserData:t}}]).factory("Project",["$http",function(e){var t=function(){return httpProcess(e,{action:"projectData"},!1,!0)};return{getProjectData:t}}]).controller("Dashboard",["$scope","User","Project","$http",function(e,t,a,n){e.user={},e.userEdit={},e.userNew={},e.projects=[],e.projectNew={};var r=t.getUserData();r.then(function(t){e.user=t.data});var i=a.getProjectData();i.then(function(t){e.projects=t.data}),e.addNewProject=function(t){if(null!==t&&"object"==typeof t&&"title"in t){var a={action:"addProject",title:t.title,tid:e.user.tid},r=httpProcess(n,a,!1,!0);r.then(function(t){e.projects.push(t.data)}),t.inValid=!1,t.title="",t.add=!1}else t.inValid=!0},e.editProject=function(t){e.activeProject=t},e.fieldPassEditUpdate=function(t,a,r,i){e.frmPass.newpass.$pristine=!1,e.frmPass.newcpass.$pristine=!1,("undefined"==typeof a.pass||a.pass.length<4)&&(e[r+"_invalid"]=!0),e[r+"_invalid"]!==!0&&e.user__newpass_invalid===!1&&(console.log("Kill"),i.newpass=a.pass1,fieldEditorUpdate(n,e,t,a,r,i))},e.fieldEdit=function(t,a,n){fieldEditor(e,t,a,n)},e.fieldEditUpdate=function(t,a,r,i){fieldEditorUpdate(n,e,t,a,r,i)},e.fieldEditCancel=function(t){e[t]=!1},e.keyEnter=function(t,a,n){if(13==n.keyCode)if(a instanceof Array)switch(a.length){case 1:t(a[0]);break;case 2:t(a[0],a[1]);break;case 3:t(a[0],a[1],a[2]);break;case 4:t(a[0],a[1],a[2],a[3]);break;case 5:t(a[0],a[1],a[2],a[3],a[4]);break;case 6:t(a[0],a[1],a[2],a[3],a[4],a[5])}else t(a);else if(a instanceof Array)for(var r=0;r<a.length;r++)if("string"==typeof a[r]){e[a[r]+"_invalid"]=!1;break}}}]).controller("Account",["$scope","$http",function(e,t){e.logout=function(){httpProcess(t,{action:"logout"},!0,!1)}}]),csApp.directive("homepage",[function(){return{restrict:"E",templateUrl:"html/home.html"}}]).directive("dashboard",[function(){return{restrict:"E",templateUrl:"html/dashboard.html"}}]).directive("copyright",[function(){var e=new Date;return{restrict:"E",template:"<span>"+e.getFullYear()+"</span>"}}]).directive("passCheck",[function(){return{require:"ngModel",link:function(e,t,a,n){var r="input[name='"+a.passCheck+"']";t.add(r).on("keyup",function(){e.$apply(function(){var e=t.val().length>=4&&t.val()===$(r).val();n.$setValidity("passlen",$(r).val().length>=4),n.$setValidity("passmatch",t.val()===$(r).val()),n.$setValidity("pass",e)})})}}}]).controller("HomePage",["$scope","$http",function(e,t){e.regval={},e.logval={},e.action=!0,e.toggleAction=function(){e.action=1!=e.action},e.login=function(e){e.submitted=!1,isValidEmail(e.email)?"pass"in e&&e.pass.length<4?e.submitted=!0:(e.action="login",httpProcess(t,e,!0,!1)):e.submitted=!0},e.register=function(e,a){if(a.submitted=!0,e){var n=jQuery("#view-reg div.intro-message");n.html();n.before(primaryLoader("reg-loader","")),n.css({display:"none"}),a.action="register",httpProcess(t,a,!0,!1)}},e.keyEnterHome=function(e,t,a){13==a.keyCode&&e(t)}}]),$(document).ready(function(){$("#contact-send-btn").click(function(){var e=$("input.contact-email"),t=$("textarea.contact-msg"),a=!0;$(".contact-email-container").removeClass("has-error"),isValidContactField(e.val(),"email")||($(".contact-email-container").addClass("has-error"),a=!1),$(".contact-msg-container").removeClass("has-error"),isValidContactField(t.val(),"length")||($(".contact-msg-container").addClass("has-error"),a=!1),a&&($(".contact-send").html("<img class='cs-loader-gif' src='img/ajax-loader.gif'/>"),$.ajax({type:"POST",url:"php/contact_form.php",data:{msg:t.val(),from:e.val()},success:function(a){console.log(a);var a=JSON.parse(a);1==a.result?(e.val(""),t.val(""),$(".contact-send").html("<p class='feedback-msg-success'>Thank you for sending us your message...</p>")):$(".contact-send").html("<p class='feedback-msg-error'>Something went wrong. Please refresh the page and send us your message again. Thank you.</p>")}}))})});