<?php 
require_once(INCLUDES_PATH.DS."config.php");
require_once(CLASSES_PATH.DS."database.php");

class Message extends DatabaseObject{
	
	// TABLE tbl_users PROPERTIES
	protected static $table_name = T_MESSAGES;
	protected static $col_id = C_MESSAGE_UNIQUE_ID;
	
	// USER PROPERTIES
	public $id;
	public $message;
	public $student_id;
	
	public function create(){
		global $db;
		$sql = "INSERT INTO " . self::$table_name . " (";
		$sql .= C_MESSAGE 				.", ";
		$sql .= C_MESSAGE_STUDENT_ID;
		$sql .=") VALUES ('";
		$sql .= $db->escape_string($this->message) 		. "', ";
		$sql .= $db->escape_string($this->student_id);
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
		$sql = "UPDATE " 			. self::$table_name . " SET ";
		$sql .= C_MESSAGE 			. "='" . $db->escape_string($this->grade) 		. "', ";
		$sql .= C_MESSAGE_STUDENT_ID 	. "=" . $db->escape_string($this->student_id) 	. " ";
		$sql .="WHERE " . self::$col_id . "=" . $db->escape_string($this->id) 		. "";
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
		$this_class->id 				= $record[C_MESSAGE_UNIQUE_ID];
		$this_class->message 			= $record[C_MESSAGE];
		$this_class->student_id 		= $record[C_MESSAGE_STUDENT_ID];
		return $this_class;
	}
}
?>