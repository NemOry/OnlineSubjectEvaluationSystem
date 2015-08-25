<?php 
require_once(INCLUDES_PATH.DS."config.php");
require_once(CLASSES_PATH.DS."database.php");

class Subject extends DatabaseObject{
	
	// TABLE tbl_users PROPERTIES
	protected static $table_name = T_SUBJECTS;
	protected static $col_id = C_SUBJECT_UNIQUE_ID;
	
	// USER PROPERTIES
	public $id;
	public $code;
	public $description;
	public $units;
	public $prereq_subject_id;
	public $course_id;
	public $year;
	public $semester;
	public $curriculum_id;
	
	public function create(){
		global $db;
		$sql = "INSERT INTO " . self::$table_name . " (";
		$sql .= C_SUBJECT_CODE 				.", ";
		$sql .= C_SUBJECT_DESCRIPTION 		.", ";
		$sql .= C_SUBJECT_UNITS 			.", ";
		$sql .= C_SUBJECT_PREREQ_SUBJECT_ID	.", ";
		$sql .= C_SUBJECT_COURSE_ID			.", ";
		$sql .= C_SUBJECT_YEAR 				.", ";
		$sql .= C_SUBJECT_SEMESTER 			.", ";
		$sql .= C_SUBJECT_CURRICULUM_ID;
		$sql .=") VALUES ('";
		$sql .= $db->escape_string($this->code) 						. "', '";
		$sql .= $db->escape_string($this->description) 					. "', ";
		$sql .= $db->escape_string($this->units) 						. ", ";
		$sql .= $db->escape_string($this->prereq_subject_id)			. ", ";
		$sql .= $db->escape_string($this->course_id) 					. ", ";
		$sql .= $db->escape_string($this->year) 						. ", ";
		$sql .= $db->escape_string($this->semester)						. ", ";
		$sql .= $db->escape_string($this->curriculum_id);
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
		$sql .= C_SUBJECT_CODE 				. "='" . $db->escape_string($this->code) 				. "', ";
		$sql .= C_SUBJECT_DESCRIPTION		. "='" . $db->escape_string($this->description) 		. "', ";
		$sql .= C_SUBJECT_UNITS 			. "=" . $db->escape_string($this->units) 				. ", ";
		$sql .= C_SUBJECT_PREREQ_SUBJECT_ID . "=" . $db->escape_string($this->prereq_subject_id) 	. ", ";
		$sql .= C_SUBJECT_COURSE_ID 		. "=" . $db->escape_string($this->course_id) 			. ", ";
		$sql .= C_SUBJECT_YEAR 				. "=" . $db->escape_string($this->year) 				. ", ";
		$sql .= C_SUBJECT_SEMESTER 			. "=" . $db->escape_string($this->semester) 			. ", ";
		$sql .= C_SUBJECT_CURRICULUM_ID 	. "=" . $db->escape_string($this->curriculum_id) 		. " ";
		$sql .="WHERE " . self::$col_id . "=" . $db->escape_string($this->id) 			. "";
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
		$this_class->id 				= $record[C_SUBJECT_UNIQUE_ID];
		$this_class->code 				= $record[C_SUBJECT_CODE];
		$this_class->description 		= $record[C_SUBJECT_DESCRIPTION];
		$this_class->units 				= $record[C_SUBJECT_UNITS];
		$this_class->prereq_subject_id 	= $record[C_SUBJECT_PREREQ_SUBJECT_ID];
		$this_class->course_id 			= $record[C_SUBJECT_COURSE_ID];
		$this_class->year 				= $record[C_SUBJECT_YEAR];
		$this_class->semester 			= $record[C_SUBJECT_SEMESTER];
		$this_class->curriculum_id 		= $record[C_SUBJECT_CURRICULUM_ID];
		return $this_class;
	}

	public static function get($student_id)
	{
		global $db;

		$sql = "SELECT * FROM ".T_SUBJECTS;
		$sql .= " INNER JOIN ".T_STUDENT_GRADES;
		$sql .= " ON ".T_SUBJECTS.".".C_SUBJECT_UNIQUE_ID;
		$sql .= " = ".T_STUDENT_GRADES.".".C_GRADE_SUBJECT_ID;
		$sql .= " WHERE ".T_STUDENT_GRADES.".".C_GRADE_STUDENT_ID." = ".$student_id;
		
		$result = self::get_by_sql($sql);

		return !empty($result) ? $result : null;
	}

	public static function getByCurriculum($id)
	{
		global $db;

		$sql = "SELECT * FROM ".T_SUBJECTS;
		$sql .= " WHERE ".C_SUBJECT_CURRICULUM_ID." = ".$id;
		
		$result = self::get_by_sql($sql);

		return !empty($result) ? $result : null;
	}
}

?>