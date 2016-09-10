<?php 

function register($arr, $db){
	$field = array();
	$field['email'] = $arr['email'];
	$field['fname'] = $arr['fname'];
	$field['lname'] = $arr['lname'];
	//Admin
	$field['role'] = 1;
	$field['password'] = $db->hashPass($arr['pass']);
	$query = $db->insert('user', $field);
	if($query !== true){
		jsonThrow(array('error' => $query));
	}
	//insert team
	else{
		$uid = $db->last_id();
		$field = array(
			'title' => $arr['team'],
			'uid' => $uid);
		$query = $db->insert('team', $field);
		if($query !== true){
			jsonThrow(array('error' => $query));
		}
		else{
			//insert team member
			$tid = $db->last_id();
			$field = array(
				'tid' => $tid,
				'uid' => $uid,
				'role' => 1);
			$query = $db->insert('team_member', $field);
			if($query !== true){
				jsonThrow(array('error' => $query));
			}
			//Register session
			$_SESSION['uid'] = $uid;
			$_SESSION['tid'] = $tid;
		}
	}
}

function userData($db){
	$result = $db->getUserData($_SESSION['uid']);
	if($result === false){
		logout();
		jsonThrow(array('error' => "User not found"));
	}
	else{
		$_SESSION['tid'] = $result['tid'];
		unset($result['tid']);
		jsonThrow($result);
	}

}

function userUpdate($arr, $db){
	if(!isLogin()){
		return;
	}
	$table = 'user';
	$cond = array(
		'uid' => $_SESSION['uid'],
		'active' => 1
		);
	$query = $db->update($table, $arr, $cond);
	if($query === false){
		jsonThrow(array('error' => "Error updating uid:".$uid." data"));
	}
}

function projectUpdate($arr, $db){
	$table = 'project';
	$xtable = 'project_member';
	$cond = array(
		$table.'.pid' => $arr['pid'],
		$table.'.tid' => $_SESSION['tid'],
		'role' => 1
		);
	unset($arr['pid']);
	$fields = array();
	if(is_array($arr)){
		foreach($arr as $k => $v){
			$fields[$table.'.'.$k] = $v; 
		}
	}
	$extra = "LEFT JOIN {$xtable} ON {$xtable}.pid = {$table}.pid AND {$xtable}.uid = {$_SESSION['uid']}";
	$query = $db->update($table, $fields, $cond, $extra);
	if($query === false){
		jsonThrow(array('error' => "Error updating db."));
	}
}

function teamUpdate($arr, $db){
	$table = 'team';
	$xtable = 'team_member';
	$cond = array(
		$table.'.tid' => $_SESSION['tid'],
		$xtable.'.role' => 1
	);
	$fields = array();
	if(is_array($arr)){
		foreach($arr as $k => $v){
			$k = ($k == 'team')? 'title' : $k;
			$k = ($k == 'team_description')? 'description' : $k;
			$fields[$table.'.'.$k] = $v; 
		}
	}
	$extra = "LEFT JOIN {$xtable} ON {$xtable}.tid = {$table}.tid AND {$xtable}.uid = {$_SESSION['uid']}";
	$query = $db->update($table, $fields, $cond, $extra);
	if($query === false){
		jsonThrow(array('error' => "Error updating db."));
	}
}

function addProject($arr, $db){
	if(!isLogin()){
		return;
	}
	if(empty($arr['title'])){
		jsonThrow(array('error' => "Project title empty."));
		return;
	}
	//Check role
	if(getTeamRole($db) == 1){
		//insert project
		$arr['uid'] = $_SESSION['uid'];
		$arr['tid'] = $_SESSION['tid'];
		$query = $db->insert('project', $arr);
		if($query !== true){
			jsonThrow(array('error' => $query));
		}
		else{
			//insert project member
			$pid = $db->last_id();
			$field = array(
				'pid' => $pid,
				'uid' => $_SESSION['uid'],
				'role' => 1
			);
			$query = $db->insert('project_member', $field);
			if($query !== true){
				jsonThrow(array('error' => $query));
			}
			//Return data
			else{
				$result=array(
					'pid' => $pid,
					'tid' => $_SESSION['tid'],
					'uid' => $_SESSION['uid'],
					'title' => $arr['title'],
					'description' => '',
					'active' => 1,
					'date_created' => dateNow(),
					'date_modify' => dateNow(),
					'role' => 1
				);
				jsonThrow($result);
			}
		}
	}
}

function projectData($db){
	//TODO get project where the user is a member of the said project
	$query = "SELECT p.*, pm.role FROM project p LEFT JOIN project_member pm ON p.pid = pm.pid WHERE p.tid = ? AND pm.uid = ?";
	$prepare = array($_SESSION['tid'], $_SESSION['uid']);
	$result = $db->query($query, $prepare); 
	jsonThrow($result);
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
	unset($_SESSION['tid']);
	unset($_SESSION);
	session_unset();
	session_destroy();
}

function getTeamRole($db){
	$prepare = array(
		$_SESSION['tid'], $_SESSION['uid']
	);
	$result = $db->query("SELECT role FROM team_member WHERE tid = ? AND uid = ?", $prepare);
	return $result[0]['role'];
}

function isLogin(){
	if(empty($_SESSION['uid'])){
		jsonThrow(array('error' => "User not found"));
		return false;
	}
	return true;
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

function dateNow(){
	return date('Y-m-d H:i:s');
}
?>