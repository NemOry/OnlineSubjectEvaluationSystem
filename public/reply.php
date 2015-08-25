<?php

require_once("../includes/initialize.php");

global $session;

if(!$session->is_logged_in())
{
    redirect_to("index.php");
}

$studentid = $_GET["studentid"];

?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8" />
	<title>View Subjects By Curriculum</title>
    <link href="css/bootstrap.min.css" rel="stylesheet"/>
</head>
<body>

	<form class="form-horizontal">
		<fieldset>
			<legend>Reply</legend>
			<div class="control-group">
			  <label class="control-label" for="message">Your Message</label>
			  <div class="controls">
			    <textarea id="message" name="message"></textarea>
			  </div>
			</div>

			<div class="control-group">
			  <label class="control-label" for="singlebutton"></label>
			  <div class="controls">
			    <button id="singlebutton" name="singlebutton" class="btn btn-primary">Send</button>
			  </div>
			</div>
		</fieldset>
	</form>


</body>
</html>