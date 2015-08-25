<?php 
defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);
defined('SITE_ROOT') ? null : 		define('SITE_ROOT', DS.'xampp'.DS.'htdocs'.DS.'SubjectEvaluation');
defined('INCLUDES_PATH') ? null : 	define('INCLUDES_PATH', SITE_ROOT.DS.'includes');
defined('PUBLIC_PATH') ? null : 	define('PUBLIC_PATH', SITE_ROOT.DS.'public');
defined('CLASSES_PATH') ? null : 	define('CLASSES_PATH', INCLUDES_PATH.DS.'classes');

// HELPERS
require_once(INCLUDES_PATH.DS."config.php");
require_once(INCLUDES_PATH.DS."functions.php");

// CORE PHPS
require_once(CLASSES_PATH.DS."database.php");
require_once(CLASSES_PATH.DS."database_object.php");
require_once(CLASSES_PATH.DS."session.php");

// OBJECT PHPS
require_once(CLASSES_PATH.DS."course.php");
require_once(CLASSES_PATH.DS."student.php");
require_once(CLASSES_PATH.DS."subject.php");
require_once(CLASSES_PATH.DS."user.php");
require_once(CLASSES_PATH.DS."grade.php");
require_once(CLASSES_PATH.DS."teacher_subject.php");
require_once(CLASSES_PATH.DS."message.php");
require_once(CLASSES_PATH.DS."evaluated_subject.php");
require_once(CLASSES_PATH.DS."evaluated_student.php");
require_once(CLASSES_PATH.DS."curriculum.php");

?>
