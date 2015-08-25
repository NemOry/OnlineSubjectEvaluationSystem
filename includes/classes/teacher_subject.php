<?php 
require_once(INCLUDES_PATH.DS."config.php");
require_once(CLASSES_PATH.DS."database.php");

class TeacherSubject extends DatabaseObject{
	
	// TABLE tbl_users PROPERTIES
	protected static $table_name = T_TEACHER_SUBJECTS;
	protected static $col_id = C_TEACHER_SUBJECTS_UNIQUE_ID;
	
	// USER PROPERTIES
	public $id;
	public $teacher_id;
	public $subject_id;
	
	public function create(){
		global $db;
		$sql = "INSERT INTO " . self::$table_name . " (";
		$sql .= C_TEACHER_SUBJECTS_TEACHER_ID			.", ";
		$sql .= C_TEACHER_SUBJECTS_SUBJECT_ID;
		$sql .=") VALUES (";
		$sql .= $db->escape_string($this->teacher_id) 	. ", ";
		$sql .= $db->escape_string($this->subject_id);
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
		$sql = "UPDATE " 							. self::$table_name . " SET ";
		$sql .= C_TEACHER_SUBJECTS_TEACHER_ID 		. "=" . $db->escape_string($this->teacher_id) 		. ", ";
		$sql .= C_TEACHER_SUBJECTS_SUBJECT_ID 		. "=" . $db->escape_string($this->subject_id) 		. " ";
		$sql .="WHERE " . self::$col_id . "=" 		. $db->escape_string($this->id) 			. "";
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
		$this_class->id 			= $record[C_TEACHER_SUBJECTS_UNIQUE_ID];
		$this_class->teacher_id 	= $record[C_TEACHER_SUBJECTS_TEACHER_ID];
		$this_class->subject_id 	= $record[C_TEACHER_SUBJECTS_SUBJECT_ID];
		return $this_class;
	}

	public static function exists($subject_id, $teacher_id)
	{
		global $db;

		$sql = "SELECT * FROM " . self::$table_name . " WHERE " . C_TEACHER_SUBJECTS_SUBJECT_ID . " = " . $subject_id . " AND " . C_TEACHER_SUBJECTS_TEACHER_ID . " = " . $teacher_id;
		$result = $db->query($sql);
		
		return ($db->get_num_rows($result) == 1) ? true : false;
	}

	public static function get_by_teacher_id($teacher_id){
		global $db;
		$sql = "SELECT * FROM " . self::$table_name . " WHERE " . C_TEACHER_SUBJECTS_TEACHER_ID . " = " . $teacher_id;
		$result = self::get_by_sql($sql);
		return !empty($result) ? $result : null;
	}

}

?>