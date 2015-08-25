<?php 
require_once(INCLUDES_PATH.DS."config.php");
require_once(CLASSES_PATH.DS."database.php");

class Grade extends DatabaseObject{
	
	// TABLE tbl_users PROPERTIES
	protected static $table_name = T_STUDENT_GRADES;
	protected static $col_id = C_GRADE_UNIQUE_ID;
	
	// USER PROPERTIES
	public $id;
	public $grade;
	public $subject_id;
	public $student_id;
	
	public function create(){
		global $db;
		$sql = "INSERT INTO " . self::$table_name . " (";
		$sql .= C_GRADE 				.", ";
		$sql .= C_GRADE_SUBJECT_ID 		.", ";
		$sql .= C_GRADE_STUDENT_ID;
		$sql .=") VALUES (";
		$sql .= $db->escape_string($this->grade) 		. ", ";
		$sql .= $db->escape_string($this->subject_id) 	. ", ";
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
		$sql .= C_GRADE 			. "=" . $db->escape_string($this->grade) 		. ", ";
		$sql .= C_GRADE_SUBJECT_ID	. "=" . $db->escape_string($this->subject_id) 	. ", ";
		$sql .= C_GRADE_STUDENT_ID 	. "=" . $db->escape_string($this->student_id) 	. " ";
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
		$this_class->id 				= $record[C_GRADE_UNIQUE_ID];
		$this_class->grade 				= $record[C_GRADE];
		$this_class->subject_id 		= $record[C_GRADE_SUBJECT_ID];
		$this_class->student_id 		= $record[C_GRADE_STUDENT_ID];
		return $this_class;
	}

	public static function exists($subject_id, $student_id){
		global $db;
		$sql = "SELECT * FROM " . self::$table_name . " WHERE " . C_GRADE_SUBJECT_ID . " = " . $subject_id . " AND " . C_GRADE_STUDENT_ID . " = " . $student_id;
		$result = $db->query($sql);
		return ($db->get_num_rows($result) == 1) ? true : false;
	}

	public static function get_by_subj_stud($subject_id, $student_id){
		global $db;
		$sql = "SELECT * FROM " . self::$table_name . " WHERE " . C_GRADE_SUBJECT_ID . " = " . $subject_id . " AND " . C_GRADE_STUDENT_ID . " = " . $student_id;
		$result = self::get_by_sql($sql);
		return !empty($result) ? array_shift($result) : null;
	}

	public static function get($student_id)
	{
		global $db;

		$sql = "SELECT * FROM ".T_STUDENT_GRADES;
		//$sql .= " WHERE ".C_GRADE_STUDENT_ID." = ".$student_id;
		$sql .= " INNER JOIN ".T_SUBJECTS;
		$sql .= " ON ".T_STUDENT_GRADES.".".C_GRADE_SUBJECT_ID;
		$sql .= " = ".T_SUBJECTS.".".C_SUBJECT_UNIQUE_ID;

		$result = self::get_by_sql($sql);

		return !empty($result) ? array_shift($result) : null;
	}
}

?>