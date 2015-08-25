<?php 
require_once(INCLUDES_PATH.DS."config.php");
require_once(CLASSES_PATH.DS."database.php");

class User extends DatabaseObject{
	
	// TABLE tbl_users PROPERTIES
	protected static $table_name = T_USERS;
	protected static $col_id = C_USER_UNIQUE_ID;
	
	// USER PROPERTIES
	public $id;
	public $level;
	public $name;
	public $username;
	public $password;
	
	public function create(){
		global $db;
		$sql = "INSERT INTO " . self::$table_name . " (";
		$sql .= C_USER_LEVEL 			.", ";
		$sql .= C_USER_NAME 			.", ";
		$sql .= C_USER_USERNAME 		.", ";
		$sql .= C_USER_PASSWORD;
		$sql .=") VALUES (";
		$sql .= $db->escape_string($this->level) 			. ", '";
		$sql .= $db->escape_string($this->name) 			. "', '";
		$sql .= $db->escape_string($this->username) 		. "', '";
		$sql .= $db->escape_string($this->password) 		. "' ";
		$sql .=")";

		if($db->query($sql)){
			$this->id = $db->get_last_id();
			return true;
		}else{
			return false;	
		}
	}
	
	public function update(){
		global $db;
		$sql = "UPDATE " 				. self::$table_name . " SET ";
		$sql .= C_USER_LEVEL			. "=" . $db->escape_string($this->level) 			. ", ";
		$sql .= C_USER_NAME 			. "='" . $db->escape_string($this->name) 			. "', ";
		$sql .= C_USER_USERNAME			. "='" . $db->escape_string($this->username) 		. "', ";
		$sql .= C_USER_PASSWORD 		. "='" . $db->escape_string($this->password) 		. "' ";
		$sql .="WHERE " . self::$col_id . "=" . $db->escape_string($this->id) 				. "";
		$db->query($sql);
		return ($db->get_affected_rows() == 1) ? true : false;
	}
	
	public function delete(){
		global $db;
		$sql = "DELETE FROM " . self::$table_name . " WHERE " . self::$col_id . "=" . $this->id . "";
		$db->query($sql);
		return ($db->get_affected_rows() == 1) ? true : false;
	}
	
	protected static function instantiate($record){
		$this_class = new self;
		$this_class->id 				= $record[C_USER_UNIQUE_ID];
		$this_class->level 				= $record[C_USER_LEVEL];
		$this_class->name 				= $record[C_USER_NAME];
		$this_class->username 			= $record[C_USER_USERNAME];
		$this_class->password 			= $record[C_USER_PASSWORD];
		return $this_class;
	}

	public static function username_exists($username){
		global $db;
		$sql = "SELECT * FROM " . self::$table_name . " WHERE " . C_USER_USERNAME . " = '" . $username . "'";
		$result = $db->query($sql);
		return ($db->get_num_rows($result) == 1) ? true : false;
	}

	public static function login($username="", $password=""){
		global $db;
		$username = $db->escape_string($username);
		$password 	= $db->escape_string($password);
		
		$sql = "SELECT * FROM " . self::$table_name;
		$sql .= " WHERE " 	. C_USER_USERNAME . " = '" . $username . "'";
		$sql .= " AND " 	. C_USER_PASSWORD . " = '" . $password . "'";
		$sql .= " LIMIT 1";
		
		$result = self::get_by_sql($sql);
		return !empty($result) ? array_shift($result) : null;
	}
}
?>