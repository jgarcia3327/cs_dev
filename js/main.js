function isValid(a,e){if("email"==e){var n=/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;return n.test(a)}return"length"==e&&a.length>0}$(document).ready(function(){$("#reg-link").click(function(){$("#view-reg").css({display:"block"}),$("#view-login").css({display:"none"})}),$("#login-link").click(function(){$("#view-reg").css({display:"none"}),$("#view-login").css({display:"block"})});$("#contact-send-btn").click(function(){var a=$("input.contact-email"),e=$("textarea.contact-msg"),n=!0;$(".contact-email-container").removeClass("has-error"),isValid(a.val(),"email")||($(".contact-email-container").addClass("has-error"),n=!1),$(".contact-msg-container").removeClass("has-error"),isValid(e.val(),"length")||($(".contact-msg-container").addClass("has-error"),n=!1),n&&($(".contact-send").html("<img class='cs-loader-gif' src='img/ajax-loader.gif'/>"),$.ajax({type:"POST",url:"php/contact_form.php",data:{msg:e.val(),from:a.val()},success:function(n){console.log(n);var n=JSON.parse(n);1==n.result?(a.val(""),e.val(""),$(".contact-send").html("<p class='feedback-msg-success'>Thank you for sending us your message...</p>")):$(".contact-send").html("<p class='feedback-msg-error'>Something went wrong. Please refresh the page and send us your message again. Thank you.</p>")}}))})});