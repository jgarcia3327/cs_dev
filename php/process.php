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
		case 'userUpdate' : 
			if(array_key_exists('email', $_POST)) break; //Disable email edit
			userUpdate($_POST, $db); break;
		case 'addProject' : addProject($_POST, $db); break;
		case 'projectData' : projectData($db); break;
		case 'projectUpdate' : projectUpdate($_POST, $db); break;
		case 'teamUpdate' : teamUpdate($_POST, $db); break;
		case 'passUpdate' : passUpdate($_POST, $db); break;
	}

	//UPDATE PROJECT TEST
	//$arr = array('title'=>'TEST FINALE 2', 'pid' => 14);
	//projectUpdate($arr, $db);

	//UPDATE USER TEST
	//$arr = array("db_table"=>"team", "title"=>"testTeam");
	//$cond = array("uid"=>49, "tid"=>24);
	//update($arr, $db, $cond);

	//PROJECT DATA TEST
	//projectData($db);

	//ADD PROJECT TEST
	//$arr = array('title'=>'TEST');
	//addProject($arr, $db);
}

?>