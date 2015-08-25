<?php 
require_once(INCLUDES_PATH.DS."config.php");
require_once(CLASSES_PATH.DS."database.php");

class Course extends DatabaseObject{
	
	// TABLE tbl_users PROPERTIES
	protected static $table_name = T_COURSES;
	protected static $col_id = C_COURSE_UNIQUE_ID;
	
	// USER PROPERTIES
	public $id;
	public $code;
	public $description;
	public $curriculum_id;
	
	public function create()
	{
		global $db;
		$sql = "INSERT INTO " . self::$table_name . " (";
		$sql .= C_COURSE_CODE.", ";
		$sql .= C_COURSE_DESCRIPTION.", ";
		$sql .= C_COURSE_CURRICULUM_ID;
		$sql .=") VALUES ('";
		$sql .= $db->escape_string($this->code)."', '";
		$sql .= $db->escape_string($this->description)."', ";
		$sql .= $db->escape_string($this->curriculum_id)."";
		$sql .=")";

		if($db->query($sql)){
			$this->id = $db->get_last_id();
			return true;
		}else{
			return false;	
		}
	}
	
	public function update()
	{
		global $db;
		$sql = "UPDATE ". self::$table_name . " SET ";
		$sql .= C_COURSE_CODE."= '" . $db->escape_string($this->code)."', ";
		$sql .= C_COURSE_DESCRIPTION."= '" . $db->escape_string($this->description)."', ";
		$sql .= C_COURSE_CURRICULUM_ID."= " . $db->escape_string($this->curriculum_id)." ";
		$sql .="WHERE " . self::$col_id . "=" . $db->escape_string($this->id) 		. "";
		$db->query($sql);
		return ($db->get_affected_rows() == 1) ? true : false;
	}
	
	public function delete()
	{
		global $db;
		$sql = "DELETE FROM " . self::$table_name . " WHERE " . self::$col_id . "=" . $this->id . "";
		$db->query($sql);
		return ($db->get_affected_rows() == 1) ? true : false;
	}
	
	protected static function instantiate($record){
		$this_class = new self;
		$this_class->id 				= $record[C_COURSE_UNIQUE_ID];
		$this_class->code 				= $record[C_COURSE_CODE];
		$this_class->description 		= $record[C_COURSE_DESCRIPTION];
		$this_class->curriculum_id 				= $record[C_COURSE_CURRICULUM_ID];
		return $this_class;
	}
}
?>