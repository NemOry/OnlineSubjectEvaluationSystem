<?php 
require_once(INCLUDES_PATH.DS."config.php");
require_once(CLASSES_PATH.DS."database.php");

class Curriculum extends DatabaseObject{
	
	// TABLE tbl_users PROPERTIES
	protected static $table_name = T_CURRICULUMS;
	protected static $col_id = C_CURRICULUM_UNIQUE_ID;
	
	// USER PROPERTIES
	public $id;
	public $curriculum;
	
	public function create(){
		global $db;
		$sql = "INSERT INTO " . self::$table_name . " (";
		$sql .= C_CURRICULUM;
		$sql .=") VALUES ('";
		$sql .= $db->escape_string($this->curriculum)."'";
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
		$sql = "UPDATE ". self::$table_name . " SET ";
		$sql .= C_CURRICULUM."= '" . $db->escape_string($this->curriculum)."' ";
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
		$this_class->id 				= $record[C_CURRICULUM_UNIQUE_ID];
		$this_class->curriculum 		= $record[C_CURRICULUM];
		return $this_class;
	}
}

?>