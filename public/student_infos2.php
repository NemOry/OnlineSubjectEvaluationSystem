<?php

require_once("../includes/initialize.php");

global $session;

if(!$session->is_logged_in()){
    redirect_to("index.php");
}

$student_id = $session->student_id;

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

    <style>
        #dialog-login-form, #dialog-group-reg-form { font-size: 62.5%; }
        label, input { display:block; color: gray;}
        input.text { margin-bottom:12px; width:95%; padding: .4em; }
        fieldset { padding:0; border:0; margin-top:25px; }
        h1 { margin: .6em 0; }
        .ui-dialog .ui-state-error { padding: .3em; }
        .validateTips { border: 1px solid transparent; padding: 0.3em; color: gray;}
    </style>

</head>

<body>

<div id="main_container">

    <header id="main_header">
        <h1>Subject Evaluation System</h1>
        <h2>Student ID <?php echo Student::get_by_id($student_id)->student_id; ?></h2>
        <h2>Subjects and Grades of <?php echo Student::get_by_id($student_id)->get_full_name(); ?></h2>
        <h2>Course <?php echo Course::get_by_id(Student::get_by_id($student_id)->course_id)->code; ?></h2>
        <h2>Semester <?php echo Student::get_by_id($student_id)->semester; ?></h2>
        <h2>Year <?php echo Student::get_by_id($student_id)->year; ?></h2>
    </header>

    <section id="main_section">

        <section id="main_content">

          <a href="#" id="btn-message" style="color:white; background: #3182c1; border:none;">Send Message to Admins</a>
          <a href="logout.php" style="color:white; background: #3182c1; border:none;">Logout</a>

          <div id="tabs">
              <ul>
                  <li><a href="student_grades_subjects2.php?student_id=<?php echo $student_id; ?>"><span>Current Subjects and Grades</span></a></li>
                  <li><a href="evaluated_subjects2.php?student_id=<?php echo $student_id; ?>"><span>Evaluated Subjects</span></a></li>
              </ul>
          </div>
          
        </section>
        
    </section>
</div>

<div id="dialog-message-form" title="Send Message">
    <p class="validateTips">All form fields are required.</p>

    <form id="messageForm">
        <fieldset>
            <label for="message">Message</label>
            <input type="text" name="message" id="message" class="text ui-widget-content ui-corner-all" />
        </fieldset>
    </form>
</div>

<script src="js/jquery.js"/></script>
<script src="js/jquery-ui.js"/></script>
<script src="js/i18n/grid.locale-en.js" type="text/javascript"></script>
<script src="js/jquery.jqGrid.min.js" type="text/javascript"></script>
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

<script>
    $(function() {
        $( "#dialog:ui-dialog" ).dialog( "destroy" );

        $( "#dialog-message-form" ).dialog({
            autoOpen: false,
            height: 270,
            width: 300,
            modal: true,
            buttons: {
                "Send": function() {

                  $.ajax({
                      type:"POST",
                      url:"send_message.php",
                      data: $('#messageForm').serialize(),
                      success: function(result){
                          if(result == "success"){
                              alert("Message sent");
                          }else{
                              alert(result);
                          }
                      },
                      error: function(jqXHR, textStatus, errorThrown){
                          alert("error");
                      }
                  });

                  return false;
                },
                Cancel: function() {
                    $( this ).dialog( "close" );
                }
            },
            close: function() {
                allFields.val( "" ).removeClass( "ui-state-error" );
            }
        });

        $( "#btn-message" ).button().click(function() {
            $( "#dialog-message-form" ).dialog( "open" );
        });

    });
</script>

</body>
</html>