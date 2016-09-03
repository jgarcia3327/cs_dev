<?php 
error_reporting(E_ERROR | E_WARNING | E_PARSE );
session_start();
date_default_timezone_set('Asia/Kuala_Lumpur');



if( isset($_POST) ){
	require 'db_class.php';
	require 'functions.php';

	$db = new touch_db();
	$action = $_POST['action'];
	unset($_POST['action']);

	switch($action){
		case 'register' : register($_POST, $db); break;
		case 'logout' : logout(); break;
		case 'login' : login($_POST, $db); break;
		case 'userData' : userData($db); break;
		case 'update' : 
			$cond = array('uid' => $_SESSION['uid']);
			if(array_key_exists('tid', $_POST)){
				$cond['tid'] = $_POST['tid'];
				unset($_POST['tid']);
			}
			update($_POST, $db, $cond); break;
	}

	//UPDATE TEST
	//$arr = array("db_table"=>"team", "title"=>"testTeam");
	//$cond = array("uid"=>49, "tid"=>24);
	//update($arr, $db, $cond);
}

?>