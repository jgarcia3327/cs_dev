<?php 

function register($arr, $db){
	$field = array();
	$field['email'] = $arr['email'];
	$field['fname'] = $arr['fname'];
	$field['lname'] = $arr['lname'];
	//Admin
	$field['role'] = 3;
	$field['password'] = $db->hashPass($arr['pass']);
	$query = $db->insert('user', $field);
	if($query !== true){
		jsonThrow(array('error' => $query));
	}
	//insert team
	else{
		$uid = $db->last_id();
		$field = array();
		$field['title'] = $arr['team'];
		$field['uid'] = $uid;
		$query = $db->insert('team', $field);
		if($query !== true){
			jsonThrow(array('error' => $query));
		}
		else{
			$_SESSION['uid'] = $uid;
		}
	}
}

function userData($uid, $db){
	if(empty($uid)){
		jsonThrow(array('error' => "User not found"));
	}
	else{
		$result = $db->getUserData($uid);
		if($result === false){
			logout();
			jsonThrow(array('error' => "User not found"));
		}
		else{
			jsonThrow($result);
		}
	}
}

function login($arr, $db){
	$f = array();
	$f['email'] = $arr['email'];
	$f['password'] = $arr['pass'];
	$uid = $db->getUID($f);
	if($uid === false){
		jsonThrow(array('error' => "Account not found"));
	}
	else{
		$_SESSION['uid'] = $uid;
	}
}

function logout(){
	unset($_SESSION['uid']);
	unset($_SESSION);
	session_unset();
	session_destroy();
}

function jsonThrow($arr){
	echo json_encode($arr, true);
}

function url(){
    if(isset($_SERVER['HTTPS'])){
        $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
    }
    else{
        $protocol = 'http';
    }
    return $protocol . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
}

?>