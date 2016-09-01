<?php 
error_reporting(E_ERROR | E_WARNING | E_PARSE );
session_start();
date_default_timezone_set('Asia/Kuala_Lumpur');



if( isset($_POST) ){
	require 'db_class.php';
	require 'functions.php';

	$db = new touch_db();

	switch($_POST['action']){
		case 'register' : register($_POST, $db); break;
		case 'logout' : logout(); break;
		case 'login' : login($_POST, $db); break;
		case 'userData' : userData($_SESSION['uid'], $db); break;
	}

	//TEST
	//$arr = array("email"=>"test@gmail.com", "pass"=>"1234");
	//login($arr, $db);
	//userData(49, $db);
}

?>