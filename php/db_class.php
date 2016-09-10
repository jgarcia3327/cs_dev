<?php 

class touch_db{

	private $pdo;
	private $last_num_rows;

	/*
	* Default fetch mode = fetch_assoc
	* Emulate prepare = false
	* This class uses value position in PDO prepare, Sample:
	* 	$query = "INSERT INTO user(`role`, `email`, `fname`, `lname`, `title`) 
	*	VALUES(?,?,?,?,?)";
	*	$stmt = $pdo->prepare($query);
	*	$stmt->execute(["999","jgarcia3327@gmail.com","Julius","Garcia","Admin"]);
	*	reference: https://phpdelusions.net/pdo
	*/
	public function __construct() {
		$host = "localhost";
		$port = "3306";
		$dbname = "lazy_agile";
		$user = "root";
		$pass = "";
		$charset = "utf8";

		$dsn = "mysql:host={$host};dbname={$dbname};port={$port};charset={$charset}";
		$opt = [
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
			PDO::ATTR_EMULATE_PREPARES => false,
		];

		$this->pdo = new PDO($dsn, $user, $pass, $opt);
		$this->last_num_rows = 0;
	}

	public function last_id(){
		return $this->pdo->lastInsertId();
	}

	/*
	* @$table = String db table name
	* @$val = Array pair value data for PDO
	* @$cond = Array condition pair value. key = field, value = field_value
	*/
	public function insert($table, $val, $cond=null){
		$prepare = array();
		//assign field value
		$fields = "";
		$values = "";
		if(is_array($val)){
			foreach($val as $k => $v){
				$fields .="`{$k}`, ";
				$values .= "?, ";
				$prepare[] = $v;
			}
			$fields = substr($fields, 0, -2);
			$values = substr($values, 0, -2);
		}
		//Condition
		$where = "";
		if(!is_null($cond) && is_array($cond)){
			$where = "WHERE ";
			foreach($cond as $k => $v){
				$where .="{$k} = ? AND ";
				$prepare[] = $v;
			}
			$where = substr($where, 0, -4);
		}
		$query = "INSERT INTO {$table}({$fields}) VALUES({$values}) ".$where;

		return $this->query($query, $prepare, true);
	}

	/*
	* @$arr = Array of condition
	*/
	public function getUID($arr){
		$prepare = array();
		$condition = "";
		$password="";
		if(is_array($arr)){
			foreach($arr as $k => $v){
				if($k == 'password'){
					$password = $v;
					continue;
				}
				$condition .= "`{$k}`"." = ? AND ";
				$prepare[] = $v;
			}
			$condition = substr($condition, 0, -4);
		}
		$query = "SELECT `uid`, `password` FROM user WHERE active AND {$condition} LIMIT 1";
		$result = $this->query($query, $prepare);

		//Email not found
		if($this->getNumRows() <= 0){
			return false;
		}

		//Verify password
		if(password_verify($password, $result[0]['password'])){
			//Correct password
			return $result[0]['uid'];
		}

		//Wrong password
		return false;
	}

	/*
	* @$uid = Int user id
	*/
	public function getUserData($uid){
		$prepare = array();
		$prepare[] = $uid;
		$query = "SELECT u.`role`, u.`email`, u.`fname`, u.`lname`, u.`title`, u.`date_created`, u.`date_modify`, t.`title` `team`, t.`description` `team_description`, t.`tid`
		FROM `user` `u` 
		LEFT JOIN `team` `t` ON u.`uid` = t.`uid`
		WHERE u.`active` AND u.`uid` = ?";
		$result = $this->query($query, $prepare);
		if(empty($result)){
			return false;
		}
		return $result[0];
	}

	/*
	* @$table = String db table name
	* @$arr = Array pair value
	* @$cond = Array condition pair value. key = field, value = field_value
	*/
	public function update($table, $arr, $cond=null, $extra=""){
		$prepare = array();
		if(is_array($arr)){
			$fields = "";
			foreach($arr as $k => $v){
				$fields .= "{$k} = ?, ";
				$prepare[] = $v;
			}
			$fields = substr($fields, 0, -2);
		}
		//Condition
		$where = "";
		if(!is_null($cond) && is_array($cond)){
			$where = "WHERE ";
			foreach($cond as $k => $v){
				$where .="{$k} = ? AND ";
				$prepare[] = $v;
			}
			$where = substr($where, 0, -4);
		}
		$query = "UPDATE `{$table}` {$extra} SET {$fields} {$where}";
		return $this->query($query, $prepare, true);
	}

	/*
	*
	*
	*/
	public function hashPass($pass){
		return password_hash($pass, PASSWORD_DEFAULT);
	}

	/*
	* General query
	*/
	public function query($query, $prepare, $bool=false){
		try{
			$stmt = $this->pdo->prepare($query);
			$stmt->execute($prepare);
			$this->last_num_rows = $stmt->rowCount();
			if($bool){
				if($this->last_num_rows > 0){
					return true;
				}
				else{
					return false;
				}
			}
			else{
				$arr = array();
				while($row = $stmt->fetch()){
					$arr[] = $row;
				}
				return $arr;
			}
		}catch(PDOException $e){
			if($e->getCode() == 23000){
				//echo "Duplicate error.";
				return "Duplicate error.";
			}
			else{
				//echo $e;
				return $e;
			}
		}
		return true;
	}

	/*
	* Get last query num_rows
	*/
	public function getNumRows(){
		return $this->last_num_rows;
	}

}

?>