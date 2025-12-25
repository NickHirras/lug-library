<?php
/*****************************************************************************
 *
 *	newsadd-2.php
 *	by Nicholas Smith imnes@go.com
 *	Written 3/3/2003
 *
 *	Copyright (C) Nicholas Smith & The Pensacola Linux Users Group
 *
 *---------------------------------------------------------------------------
 *
 *	Add news to the database.
 *
 ****************************************************************************/

session_start();
require_once("include.php");

// Include the top page template.
$page_title='Adding New Announcement';
include('header.php');

// Check incoming variables.
$story = addslashes($_POST["story"]);
$headline = addslashes($_POST["headline"]);

$form_error = 0;

if($story == "")
{
	echo "<font color=#ff0000>You must enter the full text story.</font><br>";
	$form_error = $form_error + 1;
}

if($headline == "")
{
	echo "<font color=#ff0000>You must enter the headline.</font><br>";
	$form_error = $form_error + 1;
}

if($form_error > 0)
{
	echo "Please <a href=javascript:history.back()>go back</a> and try again.";
	include('footer.php');
}
else
{
	$link = mysql_connect($db_host, $db_user, $db_pass)
		or die("Could not connect to the database.  Please try again later.");
	mysql_select_db($db_name)
		or die("Could not select the database.  Please try again later.");

	$query = "INSERT INTO news (headline, story) VALUES 
		('$headline', '$story') ";

	$result = mysql_query($query)
		or die("Invalid database query.  Please notify the webmaster.");

	echo "The news article has been added.  <br>
		<a href=index.php>Return to the homepage.</a>";
}

// Now the page footer template.
include('footer.php');
?>
