<?php 
require_once(INCLUDES_PATH.DS."config.php");
require_once(CLASSES_PATH.DS."database.php");

class Student extends DatabaseObject{
	
	// TABLE tbl_users PROPERTIES
	protected static $table_name = T_STUDENTS;
	protected static $col_id = C_STUDENT_UNIQUE_ID;
	
	// USER PROPERTIES
	public $id;
	public $student_id;
	public $password;
	public $first_name;
	public $middle_name;
	public $last_name;
	public $course_id;
	public $semester;
	public $year;
	public $level;

	public function create(){
		global $db;
		$sql = "INSERT INTO " . self::$table_name . " (";
		$sql .= C_STUDENT_ID 			.", ";
		$sql .= C_STUDENT_PASSWORD 		.", ";
		$sql .= C_STUDENT_FIRST_NAME 	.", ";
		$sql .= C_STUDENT_MIDDLE_NAME 	.", ";
		$sql .= C_STUDENT_LAST_NAME 	.", ";
		$sql .= C_STUDENT_COURSE_ID 	.", ";
		$sql .= C_STUDENT_SEMESTER 		.", ";
		$sql .= C_STUDENT_YEAR			.", ";
		$sql .= C_STUDENT_LEVEL;
		$sql .=") VALUES ('";
		$sql .= $db->escape_string($this->student_id) 		. "', '";
		$sql .= $db->escape_string($this->password) 		. "', '";
		$sql .= $db->escape_string($this->first_name) 		. "', '";
		$sql .= $db->escape_string($this->middle_name) 		. "', '";
		$sql .= $db->escape_string($this->last_name) 		. "', ";
		$sql .= $db->escape_string($this->course_id)		. ", ";
		$sql .= $db->escape_string($this->semester)			. ", ";
		$sql .= $db->escape_string($this->year)				. ", ";
		$sql .= $db->escape_string(3);
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
		$sql .= C_STUDENT_ID 				. "='" . $db->escape_string($this->student_id) 	. "', ";
		$sql .= C_STUDENT_PASSWORD			. "='" . $db->escape_string($this->password) 	. "', ";
		$sql .= C_STUDENT_FIRST_NAME 		. "='" . $db->escape_string($this->first_name) 	. "', ";
		$sql .= C_STUDENT_MIDDLE_NAME 		. "='" . $db->escape_string($this->middle_name) . "', ";
		$sql .= C_STUDENT_LAST_NAME 		. "='" . $db->escape_string($this->last_name) 	. "', ";
		$sql .= C_STUDENT_COURSE_ID 		. "=" . $db->escape_string($this->course_id) 	. ", ";
		$sql .= C_STUDENT_SEMESTER 			. "=" . $db->escape_string($this->semester) 	. ", ";
		$sql .= C_STUDENT_YEAR 				. "=" . $db->escape_string($this->year) 		. ", ";
		$sql .= C_STUDENT_LEVEL 			. "= 3 ";
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
		$this_class->id 				= $record[C_STUDENT_UNIQUE_ID];
		$this_class->student_id 		= $record[C_STUDENT_ID];
		$this_class->password 			= $record[C_STUDENT_PASSWORD];
		$this_class->first_name 		= $record[C_STUDENT_FIRST_NAME];
		$this_class->middle_name 		= $record[C_STUDENT_MIDDLE_NAME];
		$this_class->last_name 			= $record[C_STUDENT_LAST_NAME];
		$this_class->course_id 			= $record[C_STUDENT_COURSE_ID];
		$this_class->semester 			= $record[C_STUDENT_SEMESTER];
		$this_class->year 				= $record[C_STUDENT_YEAR];
		$this_class->level 				= $record[C_STUDENT_LEVEL];
		return $this_class;
	}

	public function get_full_name(){
		return $this->first_name . " " . $this->middle_name ." " . $this->last_name;
	}

	public static function login($student_id="", $password=""){
		global $db;
		$student_id = $db->escape_string($student_id);
		$password 	= $db->escape_string($password);
		
		$sql = "SELECT * FROM " . self::$table_name;
		$sql .= " WHERE " 	. C_STUDENT_UNIQUE_ID . " = " . $student_id . " ";
		$sql .= " AND " 	. C_STUDENT_PASSWORD . " = '" . $password . "'";
		$sql .= " LIMIT 1";
		
		$result = self::get_by_sql($sql);
		return !empty($result) ? array_shift($result) : null;
	}
}
?>