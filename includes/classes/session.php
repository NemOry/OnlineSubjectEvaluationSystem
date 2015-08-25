<?php 

class Session{
	
	private $logged_in;
	public $user_id;
	public $student_id;
	public $level;
	
	function __construct(){
		session_start();
		$this->check_login();
	}

	private function check_login(){
		if(isset($_SESSION[C_USER_UNIQUE_ID]) || isset($_SESSION[C_STUDENT_UNIQUE_ID])){
			$this->user_id 		= $_SESSION[C_USER_UNIQUE_ID];
			$this->student_id 	= $_SESSION[C_STUDENT_UNIQUE_ID];
			$this->level 		= $_SESSION[C_USER_LEVEL];
			$this->logged_in 	= true;
		}else{
			unset($this->user_id);
			unset($this->student_id);
			unset($this->level);
			$this->logged_in = false;
		}
	}
	
	public function is_logged_in(){
		return $this->logged_in;
	}
	
	public function login($user){
		if($user){
			$this->level 			= $_SESSION[C_USER_LEVEL] 			= $user->level;
			$this->user_id 			= $_SESSION[C_USER_UNIQUE_ID] 		= $user->id;
			$this->student_id 		= $_SESSION[C_STUDENT_UNIQUE_ID] 	= $user->id;
		}
	}
	
	public function logout(){

		unset($_SESSION[C_USER_LEVEL]);
		unset($this->level);

		unset($_SESSION[C_USER_UNIQUE_ID]);
		unset($this->user_id);

		unset($_SESSION[C_STUDENT_UNIQUE_ID]);
		unset($this->student_id);
		
		$this->logged_in = false;
	}
}

$session = new Session();

?>