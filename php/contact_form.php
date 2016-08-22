<?php
$msg = $_POST['msg'];
$from = $_POST['from'];
$status['post'] = $_POST;

if(strlen($msg) < 2 || !filter_var($from, FILTER_VALIDATE_EMAIL)){
	$status['result'] = false;
}
else{
	$to = "webmaster@cebushopping.com";
	$subject = "CebuShopping Contact us - Message";
	$headers = "From: ". $from . "\r\n";
	
	$status['result'] = mail($to,$subject,$msg,$headers);
}

echo json_encode($status);
?>