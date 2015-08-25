<?php 
// ----------------------------------------- DATABASE PROPERTIES CONSTANTS  ----------------------------------------- \\

// FOR DEVELOPMENT
defined('DB_SERVER') ? null : 				define("DB_SERVER"					, "localhost");
defined('DB_USER') ? null : 				define("DB_USER"					, "root");
defined('DB_PASS') ? null : 				define("DB_PASS"					, "");
defined('DB_NAME') ? null : 				define("DB_NAME"					, "db_subject_evaluation");

// ----------------------------------------- TABLE CONSTANTS  ------------------------------------------------------- \\

defined('T_USERS') ? null :					define("T_USERS"					, "tbl_users");
defined('T_STUDENTS') ? null :				define("T_STUDENTS"					, "tbl_students");
defined('T_SUBJECTS') ? null :				define("T_SUBJECTS"					, "tbl_subjects");
defined('T_COURSES') ? null :				define("T_COURSES"					, "tbl_courses");
defined('T_STUDENT_GRADES') ? null :		define("T_STUDENT_GRADES"			, "tbl_student_grades");
defined('T_TEACHER_SUBJECTS') ? null :		define("T_TEACHER_SUBJECTS"			, "tbl_teacher_subjects");
defined('T_MESSAGES') ? null :				define("T_MESSAGES"					, "tbl_messages");
defined('T_EVALUATED_SUBJECTS') ? null :	define("T_EVALUATED_SUBJECTS"		, "tbl_evaluated_subjects");
defined('T_CURRICULUMS') ? null :			define("T_CURRICULUMS"				, "tbl_curriculums");

// ----------------------------------------- TABLE  ------------------------------------------- \\

defined('C_USER_UNIQUE_ID') ? null : 		define("C_USER_UNIQUE_ID"			, "id");
defined('C_USER_NAME') ? null : 			define("C_USER_NAME"				, "name");
defined('C_USER_USERNAME') ? null : 		define("C_USER_USERNAME"			, "username");
defined('C_USER_PASSWORD') ? null : 		define("C_USER_PASSWORD"			, "password");
defined('C_USER_LEVEL') ? null : 			define("C_USER_LEVEL"				, "level");

// ----------------------------------------- TABLE  -------------------------------------- \\

defined('C_STUDENT_UNIQUE_ID') ? null : 	define("C_STUDENT_UNIQUE_ID"		, "id");
defined('C_STUDENT_ID') ? null : 			define("C_STUDENT_ID"				, "student_id");
defined('C_STUDENT_PASSWORD') ? null : 		define("C_STUDENT_PASSWORD"			, "password");
defined('C_STUDENT_FIRST_NAME') ? null : 	define("C_STUDENT_FIRST_NAME"		, "first_name");
defined('C_STUDENT_MIDDLE_NAME') ? null : 	define("C_STUDENT_MIDDLE_NAME"		, "middle_name");
defined('C_STUDENT_LAST_NAME') ? null : 	define("C_STUDENT_LAST_NAME"		, "last_name");
defined('C_STUDENT_COURSE_ID') ? null : 	define("C_STUDENT_COURSE_ID"		, "course_id");
defined('C_STUDENT_SEMESTER') ? null : 		define("C_STUDENT_SEMESTER"			, "semester");
defined('C_STUDENT_YEAR') ? null : 			define("C_STUDENT_YEAR"				, "year");
defined('C_STUDENT_LEVEL') ? null : 		define("C_STUDENT_LEVEL"			, "level");

// ----------------------------------------- TABLE  ------------------------------------------- \\

defined('C_SUBJECT_UNIQUE_ID') ? null : 	define("C_SUBJECT_UNIQUE_ID"		, "id");
defined('C_SUBJECT_CODE') ? null : 			define("C_SUBJECT_CODE"				, "code");
defined('C_SUBJECT_DESCRIPTION') ? null : 	define("C_SUBJECT_DESCRIPTION"		, "description");
defined('C_SUBJECT_UNITS') ? null : 		define("C_SUBJECT_UNITS"			, "units");
defined('C_SUBJECT_PREREQ_SUBJECT_ID') ? null : define("C_SUBJECT_PREREQ_SUBJECT_ID", "prereq_subject_id");
defined('C_SUBJECT_COURSE_ID') ? null : 	define("C_SUBJECT_COURSE_ID"		, "course_id");
defined('C_SUBJECT_YEAR') ? null : 			define("C_SUBJECT_YEAR"				, "year");
defined('C_SUBJECT_SEMESTER') ? null : 		define("C_SUBJECT_SEMESTER"			, "semester");
defined('C_SUBJECT_CURRICULUM_ID') ? null : define("C_SUBJECT_CURRICULUM_ID"	, "curriculum_id");

// ----------------------------------------- TABLE  ------------------------------------------- \\

defined('C_COURSE_UNIQUE_ID') ? null : 		define("C_COURSE_UNIQUE_ID"			, "id");
defined('C_COURSE_CODE') ? null : 			define("C_COURSE_CODE"				, "code");
defined('C_COURSE_DESCRIPTION') ? null : 	define("C_COURSE_DESCRIPTION"		, "description");
defined('C_COURSE_CURRICULUM_ID') ? null : 			define("C_COURSE_CURRICULUM_ID"				, "curriculum_id");

// ----------------------------------------- TABLE  ------------------------------------------- \\

defined('C_GRADE_UNIQUE_ID') ? null : 	define("C_GRADE_UNIQUE_ID"				, "id");
defined('C_GRADE') ? null : 			define("C_GRADE"						, "grade");
defined('C_GRADE_SUBJECT_ID') ? null : 	define("C_GRADE_SUBJECT_ID"				, "subject_id");
defined('C_GRADE_STUDENT_ID') ? null : 	define("C_GRADE_STUDENT_ID"				, "student_id");

// ----------------------------------------- TABLE  ------------------------------------------- \\

defined('C_TEACHER_SUBJECTS_UNIQUE_ID') ? null : 	define("C_TEACHER_SUBJECTS_UNIQUE_ID"	, "id");
defined('C_TEACHER_SUBJECTS_TEACHER_ID') ? null : 	define("C_TEACHER_SUBJECTS_TEACHER_ID"	, "teacher_id");
defined('C_TEACHER_SUBJECTS_SUBJECT_ID') ? null : 	define("C_TEACHER_SUBJECTS_SUBJECT_ID"	, "subject_id");

// ----------------------------------------- TABLE  ------------------------------------------- \\

defined('C_MESSAGE_UNIQUE_ID') ? null : 	define("C_MESSAGE_UNIQUE_ID"	, "id");
defined('C_MESSAGE') ? null : 				define("C_MESSAGE"				, "message");
defined('C_MESSAGE_STUDENT_ID') ? null : 	define("C_MESSAGE_STUDENT_ID"	, "student_id");

// ----------------------------------------- TABLE  ------------------------------------------- \\

defined('C_EVALUATED_UNIQUE_ID') ? null : 	define("C_EVALUATED_UNIQUE_ID"		, "id");
defined('C_EVALUATED_SUBJECT_ID') ? null : 	define("C_EVALUATED_SUBJECT_ID"		, "subject_id");
defined('C_EVALUATED_STUDENT_ID') ? null : 	define("C_EVALUATED_STUDENT_ID"		, "student_id");
defined('C_EVALUATED_DATE') ? null : 		define("C_EVALUATED_DATE"			, "date");

// ----------------------------------------- TABLE  ------------------------------------------- \\

defined('C_CURRICULUM_UNIQUE_ID') ? null : 	define("C_CURRICULUM_UNIQUE_ID"		, "id");
defined('C_CURRICULUM') ? null : 			define("C_CURRICULUM"				, "curriculum");

// ----------------------------------------- OTHER  ------------------------------------------- \\

defined('LEVEL_ADMIN') ? null : 		define("LEVEL_ADMIN"		, 0);
defined('LEVEL_EVALUATOR') ? null : 	define("LEVEL_EVALUATOR"	, 1);
defined('LEVEL_TEACHER') ? null : 		define("LEVEL_TEACHER"		, 2);
defined('LEVEL_STUDENT') ? null : 		define("LEVEL_STUDENT"		, 3);

?>