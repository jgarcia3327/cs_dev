
$(document).ready(function(){

	$("#reg-link").click(function(){
		$("#view-reg").css({"display":"block"});
		$("#view-login").css({"display":"none"});
	});
	$("#login-link").click(function(){
		$("#view-reg").css({"display":"none"});
		$("#view-login").css({"display":"block"});
	});

	var msg_box = "";
	$("#contact-send-btn").click(function(){
		var email = $("input.contact-email");
		var msg = $("textarea.contact-msg");
		var isProcess = true;
		//Check value
		$(".contact-email-container").removeClass("has-error");
		if(!isValid(email.val(), "email")){
			$(".contact-email-container").addClass("has-error");
			isProcess = false;
		}
		$(".contact-msg-container").removeClass("has-error");
		if(!isValid(msg.val(), "length")){
			$(".contact-msg-container").addClass("has-error");
			isProcess = false;
		}
		if(isProcess){	
			$(".contact-send").html("<img class='cs-loader-gif' src='img/ajax-loader.gif'/>"); 
			$.ajax({
			    type: "POST",
			    url: 'php/contact_form.php',
			    data: {msg: msg.val(), from: email.val()},
			    success: function(data){
			    	console.log(data);
			    	var data = JSON.parse(data);
			        if(data.result==true){
			        	email.val("");
			        	msg.val("");
			        	$(".contact-send").html("<p class='feedback-msg-success'>Thank you for sending us your message...</p>");
			    	}
			        else{
			        	$(".contact-send").html("<p class='feedback-msg-error'>Something went wrong. Please refresh the page and send us your message again. Thank you.</p>");
			        }    	
			    }
			});
		}
	});

});

function isValid(val, element) {
	if(element == "email"){
		var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  		return regex.test(val);
	}
	else if(element == "length"){
		if(val.length > 0){
			return true;
		}
	}
	return false;
}

