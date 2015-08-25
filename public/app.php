<?php

require_once("../includes/initialize.php");

global $session;

if(!$session->is_logged_in()){
//     redirect_to("index.php");
// }else{
//     if(isset($session->student_id)){
        redirect_to("index.php");
    //}
}

?>
<!DOCTYPE HTML>
<html>
<head>

    <meta charset="UTF-8" />
	<title>LasalTech Subject Advising System</title>

    <link href="css/fonts.css" rel="stylesheet"/>
    <link href="css/app.css" rel="stylesheet"/>
    <link href="css/bundledfun-ui/jquery-ui-1.8.23.custom.css" rel="stylesheet" media="screen" />
    <link href="css/ui.jqgrid.css" rel="stylesheet" media="screen" />
    <!-- <link href="css/bootstrap.min.css" rel="stylesheet"/> -->
</head>

<body style="background:#235c88;">

    <div id="main_container">

        <header id="main_header">
            <h1>Subject Advising System</h1>
            <h2>User: <?php echo User::get_by_id($session->user_id)->username; ?></h2>
            <h2>Academic Year: <?php echo date("Y")."-".(date("Y")+1); ?></h2>
        </header>
 
        <section id="main_section">

            <section id="main_content">

                <a href="logout.php" style="color:white;">Logout</a>
                
                <div id="tabs">
                    <ul>

                        <?php

                        $users_enabled = false;
                        $courses_enabled = false;
                        $students_enabled = false;
                        $subjects_enabled = false;
                        $messages_enabled = false;
                        $eval_students_enabled = false;
                        $curriculums_enabled = false;
                        $teacher_subjects_enabled = false;

                        if($session->level == LEVEL_ADMIN){
                            
                            $courses_enabled = true;
                            $users_enabled = true;
                            $students_enabled = true;
                            $subjects_enabled = true;
                            $messages_enabled = true;
                            $eval_students_enabled = true;
                            $curriculums_enabled = true;
                            $teacher_subjects_enabled = true;
                            
                        }else if($session->level == LEVEL_EVALUATOR){
                            
                            $students_enabled = true;
                            $eval_students_enabled = true;
                            
                        }else if($session->level == LEVEL_TEACHER){
                            
                            //$students_enabled = true;
                            $subjects_enabled = true;

                            //$teacher_subjects_enabled = true;
                            
                        }else if($session->level == LEVEL_STUDENT){
                            
                            redirect_to("student_something.php");
                            
                        }

                        if($users_enabled){echo '<li><a href="users.php"><span>Users</span></a></li>'; }
                        if($courses_enabled){echo '<li><a href="courses.php"><span>Courses</span></a></li>'; }
                        if($students_enabled){echo '<li><a href="students.php"><span>Students</span></a></li>'; }
                        if($eval_students_enabled){echo '<li><a href="evaluated_students.php"><span>Evaluated Students</span></a></li>'; }
                        if($subjects_enabled){echo '<li><a href="subjects.php"><span>Subjects</span></a></li>'; }
                        if($messages_enabled){echo '<li><a href="messages.php"><span>Messages</span></a></li>'; }
                        if($curriculums_enabled){echo '<li><a href="curriculums.php"><span>Curriculums</span></a></li>'; }

                        if($teacher_subjects_enabled){echo '<li><a href="teacher_subjects.php"><span>Teacher Subjects</span></a></li>'; }
                        
                        ?>

                    </ul>
                </div>
            </section>
            
        </section>
    </div>

    <script src="js/jquery.js"/></script>
    <script src="js/jquery-ui.js"/></script>
    <script src="js/i18n/grid.locale-en.js"></script>
    <script src="js/jquery.jqGrid.min.js"></script>
    <script src="js/jquery.printPage.js"></script>
    <script src="js/bootstrap.js"/></script>

    <script>
    
     $(function() {
        $('#tabs').tabs({
            load: function(event, ui) {
                $(ui.panel).delegate('a', 'click', function(event) {
                    $(ui.panel).load(this.href);
                    event.preventDefault();
                });
            }
        });

        $(".btnPrint").printPage();
    });

    </script>

</body>
</html>