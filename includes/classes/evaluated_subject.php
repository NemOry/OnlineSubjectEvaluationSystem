<?php 
require_once(INCLUDES_PATH.DS."config.php");
require_once(CLASSES_PATH.DS."database.php");

class EvaluatedSubject extends DatabaseObject{
	
	// TABLE tbl_users PROPERTIES
	protected static $table_name = T_EVALUATED_SUBJECTS;
	protected static $col_id = C_EVALUATED_UNIQUE_ID;
	
	// USER PROPERTIES
	public $id;
	public $subject_id;
	public $student_id;
	public $date;
	
	public function create(){
		global $db;
		$sql = "INSERT INTO " . self::$table_name . " (";
		$sql .= C_EVALUATED_SUBJECT_ID			.", ";
		$sql .= C_EVALUATED_STUDENT_ID			.", ";
		$sql .= C_EVALUATED_DATE;
		$sql .=") VALUES (";
		$sql .= $db->escape_string($this->subject_id) 	. ", ";
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
		$sql = "UPDATE " 					. self::$table_name . " SET ";
		$sql .= C_EVALUATED_SUBJECT_ID 		. "=" . $db->escape_string($this->subject_id) 		. ", ";
		$sql .= C_EVALUATED_STUDENT_ID 		. "=" . $db->escape_string($this->student_id) 		. ", ";
		$sql .= C_EVALUATED_DATE 		. "=" . $db->escape_string($this->date) 		. " ";
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
		$this_class->id 			= $record[C_EVALUATED_UNIQUE_ID];
		$this_class->subject_id 	= $record[C_EVALUATED_SUBJECT_ID];
		$this_class->student_id 	= $record[C_EVALUATED_STUDENT_ID];
		$this_class->date 			= $record[C_EVALUATED_DATE];
		return $this_class;
	}


	public static function get_by_student_id($student_id){
		global $db;
		$sql = "SELECT * FROM " . self::$table_name . " WHERE " . C_EVALUATED_STUDENT_ID . " = " . $student_id;
		$result = self::get_by_sql($sql);
		return !empty($result) ? array_shift($result) : null;
	}

	public static function exists($subject_id, $student_id){
		global $db;
		$sql = "SELECT * FROM " . self::$table_name . " WHERE " . C_EVALUATED_SUBJECT_ID . " = " . $subject_id . " AND " . C_EVALUATED_STUDENT_ID . " = " . $student_id;
		$result = $db->query($sql);
		return ($db->get_num_rows($result) == 1) ? true : false;
	}
}
?>