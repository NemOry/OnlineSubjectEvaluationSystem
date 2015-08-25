<?php

require_once("../includes/initialize.php");

global $session;

if($session->is_logged_in()){
    
    // if(isset($session->student_id)){
    //     redirect_to("student_infos2.php");
    // }elseif(isset($session->user_id)){
        redirect_to("app.php");
    // }
}

?>
<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
	<title>Subject Evaluation System</title>
    <link href="css/home.css" rel="stylesheet"/>
    <link href="css/fonts.css" rel="stylesheet"/>
    <link href="css/bundledfun-ui/jquery-ui-1.8.23.custom.css" rel="stylesheet" media="screen" />
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
        <h1 id="myheader">LasalleTech Subject Advising System</h1>
        <nav id="main_nav">
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">About Us</a></li>
                <li><a href="#" id="btn-login" style="color:white; background: #3182c1; border:none;">Login</a></li>
                <li><a href="#" id="student_btn-login" style="color:white; background: #3182c1; border:none;">Student Login</a></li>
            </ul>
        </nav>
        
        <div id="image_header">
            <!-- <img src="images/bundledfun-header.jpg"/> -->
        </div>
    </header>
    
    <section id="main_section">
 
    </section>
    
    <footer id="main_footer">
        <p>&copy; Copyright 2013 Designed by Super Mario's Group</a></p>
    </footer>
</div>

<div id="dialog-login-form" title="Login">
    <p class="validateTips">All form fields are required.</p>

    <form id="loginForm">
        <fieldset>
            <label for="username">Username</label>
            <input type="text" name="login_username" id="login_username" class="text ui-widget-content ui-corner-all" />
            <label for="password">Password</label>
            <input type="password" name="login_password" id="login_password" value="" class="text ui-widget-content ui-corner-all" />
        </fieldset>
    </form>
</div>

<div id="student_dialog-login-form" title="Login">
    <p class="validateTips">All form fields are required.</p>

    <form id="student_loginForm">
        <fieldset>
            <label for="student_id">Student ID</label>
            <input type="text" name="student_login_student_id" id="student_login_student_id" class="text ui-widget-content ui-corner-all" />
            <label for="password">Password</label>
            <input type="password" name="student_login_password" id="student_login_password" value="" class="text ui-widget-content ui-corner-all" />
        </fieldset>
    </form>
</div>


<script src="js/jquery.js"/></script>
<script src="js/jquery-ui.js"/></script>
<script>
    $(function() {
        $( "#dialog:ui-dialog" ).dialog( "destroy" );

        function updateTips( t ) {
            tips.text( t ).addClass( "ui-state-highlight" );
            setTimeout(function() {
                tips.removeClass( "ui-state-highlight", 1500 );
            }, 500 );
        }

        function checkLength( o, n, min, max ) {
            if ( o.val().length > max || o.val().length < min ) {
                o.addClass( "ui-state-error" );
                updateTips( "Length of " + n + " must be between " +
                    min + " and " + max + "." );
                return false;
            } else {
                return true;
            }
        }

        function checkRegexp( o, regexp, n ) {
            if ( !( regexp.test( o.val() ) ) ) {
                o.addClass( "ui-state-error" );
                updateTips( n );
                return false;
            } else {
                return true;
            }
        }

        var login_username = $( "#login_username" ),
            login_password = $( "#login_password" ),
            allFields = $( [] ).add( login_username ).add( login_password ),
            tips = $( ".validateTips" );
        
        $( "#dialog-login-form" ).dialog({
            autoOpen: false,
            height: 270,
            width: 300,
            modal: true,
            buttons: {
                "Login": function() {
                    var bValid = true;
                    allFields.removeClass( "ui-state-error" );

                    bValid = bValid && checkLength( login_username, "login_username", 1, 16 );
                    bValid = bValid && checkLength( login_password, "login_password", 1, 16 );

                    bValid = bValid && checkRegexp( login_username, /^[a-z]([0-9a-z_])+$/i, "Username may consist of a-z, 0-9, underscores, begin with a letter." );
                    bValid = bValid && checkRegexp( login_password, /^([0-9a-zA-Z])+$/, "Password field only allow : a-z 0-9" );

                    if ( bValid ) {
                        $.ajax({
                            type:"POST",
                            url:"login.php",
                            data: $('#loginForm').serialize(),
                            success: function(result){
                                if(result == "success"){
                                    window.location.href = "app.php";
                                }else{
                                    alert(result);
                                }
                            },
                            error: function(jqXHR, textStatus, errorThrown){
                                alert("error");
                            }
                        });

                        return false;
                    }
                },
                Cancel: function() {
                    $( this ).dialog( "close" );
                }
            },
            close: function() {
                allFields.val( "" ).removeClass( "ui-state-error" );
            }
        });

        $( "#btn-login" ).button().click(function() {
                $( "#dialog-login-form" ).dialog( "open" );
        });

        /////////////////////////////////////////////////////////

        $( "#student_dialog-login-form" ).dialog({
            autoOpen: false,
            height: 270,
            width: 300,
            modal: true,
            buttons: {
                "Student Login": function() {
                    var bValid = true;
                    allFields.removeClass( "ui-state-error" );

                    if ( bValid ) {
                        $.ajax({
                            type:"POST",
                            url:"login_student.php",
                            data: $('#student_loginForm').serialize(),
                            success: function(result){
                                if(result == "success"){
                                    window.location.href = "student_infos2.php";
                                }else{
                                    alert(result);
                                }
                            },
                            error: function(jqXHR, textStatus, errorThrown){
                                alert("error");
                            }
                        });

                        return false;
                    }
                },
                Cancel: function() {
                    $( this ).dialog( "close" );
                }
            },
            close: function() {
                allFields.val( "" ).removeClass( "ui-state-error" );
            }
        });
        
        $( "#student_btn-login" ).button().click(function() {
            $( "#student_dialog-login-form" ).dialog( "open" );
        });

    });
</script>

</body>
</html>