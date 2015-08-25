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

$subject = Subject::get_by_id($_GET['subject_id']);

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
            <h2>Subject : <?php echo $subject->description; ?></h2>
        </header>
 
        <section id="main_section">
            <section id="main_content">
                <a href="logout.php" style="color:white;">Logout</a>
                <div id="tabs">
                    <ul>
                        <?php echo '<li><a href="teacherstudentsgrid.php?subject_id='.$subject->id.'"><span>Teacher Students</span></a></li>'; ?>
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