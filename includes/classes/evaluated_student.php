<?php 
require_once(INCLUDES_PATH.DS."config.php");
require_once(CLASSES_PATH.DS."database.php");

class EvaluatedStudent extends DatabaseObject{
	
	// TABLE tbl_users PROPERTIES
	protected static $table_name = "tbl_evaluated_students";
	protected static $col_id = "id";
	
	// USER PROPERTIES
	public $id;
	public $student_id;
	public $date;
	
	public function create(){
		global $db;
		$sql = "INSERT INTO " . self::$table_name . " (";
		$sql .= "student_id"			.", ";
		$sql .= "date";
		$sql .=") VALUES (";
		$sql .= $db->escape_string($this->student_id) 	. ", ";
		$sql .= "CURDATE()";
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
		$sql .= "student_id" 	. "=" . $db->escape_string($this->student_id) 		. ", ";
		$sql .= "date" 		. "= CURDATE() ";
		$sql .="WHERE " . self::$col_id . "='" . $db->escape_string($this->id) 			. "'";
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
		$this_class->id 			= $record["id"];
		$this_class->student_id 	= $record["student_id"];
		$this_class->date 			= $record["date"];
		return $this_class;
	}

	public static function exists($student_id)
	{
		global $db;

		$sql = "SELECT * FROM " . self::$table_name . " WHERE " . "student_id" . " = " . $student_id;
		
		$result = $db->query($sql);

		return ($db->get_num_rows($result) == 1) ? true : false;
	}
}

?>