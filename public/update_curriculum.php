<?php
require_once("../includes/initialize.php");

global $session;

if(!$session->is_logged_in()){
    redirect_to("index.php");
}

if($_POST['oper']=='add'){

	$curriculum = new Curriculum();
	$curriculum->curriculum = $_POST['curriculum'];
	$curriculum->create();

}else if($_POST['oper']=='edit'){

	$curriculum = Curriculum::get_by_id($_POST['id']);
	$curriculum->curriculum 			= $_POST['curriculum'];
	$curriculum->update();

}else if($_POST['oper']=='del'){
	Curriculum::get_by_id($_POST['id'])->delete();
}

?>