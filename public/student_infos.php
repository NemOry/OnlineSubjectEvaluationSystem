<?php

require_once("../includes/initialize.php");

global $session;

if(!$session->is_logged_in()){
    redirect_to("index.php");
}

$student_id = $_GET['student_id'];

$student = Student::get_by_id($student_id);

?>
<!DOCTYPE HTML>
<html>
<head>

    <meta charset="UTF-8" />
  <title>Subject Evaluation System</title>

    <link href="css/fonts.css" rel="stylesheet"/>
    <link href="css/app.css" rel="stylesheet"/>
    <link href="css/bundledfun-ui/jquery-ui-1.8.23.custom.css" rel="stylesheet" media="screen" />
    <link href="css/ui.jqgrid.css" rel="stylesheet" media="screen" />

</head>

<body>

<div id="main_container">

    <header id="main_header">
        <h1>Subject Evaluation System</h1>
        <h2>Subjects and Grades of <?php echo Student::get_by_id($_GET['student_id'])->get_full_name(); ?></h2>
        <h2>Course <?php echo Course::get_by_id(Student::get_by_id($_GET['student_id'])->course_id)->code; ?></h2>
        <h2>Semester <?php echo Student::get_by_id($_GET['student_id'])->semester; ?></h2>
        <h2>Year Level <?php echo Student::get_by_id($_GET['student_id'])->year; ?></h2>
    </header>

    <section id="main_section">

        <section id="main_content">

          <a href="logout.php" style="color:white;">Logout</a>
          
          <div id="tabs">
              <ul>

                  <?php

                  $student_grades_subjects_enabled = false;
                  $evaluated_subjects_enabled = false;

                  if($session->level == LEVEL_ADMIN){

                      $student_grades_subjects_enabled = true;
                      $evaluated_subjects_enabled = true;

                  }else if($session->level == LEVEL_EVALUATOR){

                      $student_grades_subjects_enabled = true;
                      $evaluated_subjects_enabled = true;

                  }else if($session->level == LEVEL_TEACHER){

                      $student_grades_subjects_enabled = true;

                  }else if($session->level == LEVEL_STUDENT){

                      redirect_to("student_something.php");

                  }

                  if($student_grades_subjects_enabled){echo '<li><a href="student_grades_subjects.php?student_id='.$student_id.'"><span>Subjects and Grades</span></a></li>'; }
                  if($evaluated_subjects_enabled){echo '<li><a href="evaluated_subjects.php?student_id='.$student_id.'"><span>Evaluate</span></a></li>'; }
                  
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