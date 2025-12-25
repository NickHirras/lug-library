<?php
/*****************************************************************************
 *
 *      signup-2.php
 *      by Nicholas Smith imnes@go.com
 *      Written 3/3/2003
 *
 *      Copyright (C) Nicholas Smith & The Pensacola Linux Users Group
 *
 *---------------------------------------------------------------------------
 *
 *	Process the signup form.  Validate the data.  Add the user to
 *	the database.
 *
 ****************************************************************************/

//
//  Get session information going, we need it for the navbar if nothing else.
//
session_start();
require_once("include.php");

//
//  Validate the incoming variables.
//
$return_url = $_GET["return_url"];
$email = addslashes($_POST["email"]);
$nick_name = addslashes($_POST["nick_name"]);
$first_name = addslashes($_POST["first_name"]);
$last_name = addslashes($_POST["last_name"]);
$password = $_POST["password"];
$confirm_password = $_POST["confirm_password"];
$form_error = 0;

if($nick_name == "") $nick_name = " ";
if($first_name == "") $first_name = " ";
if($last_name == "") $last_name = " ";

if($return_url == "")
{
	$return_url="login.php";
}

if($email == "")
{
	echo "<font color=#ff0000>You must enter a valid email address.</font>
              <br>";
	$form_error = 1;
}

if($password == "")
{
	echo "<font color=#ff0000>Password may not be empty.</font><br>";
	$form_error = 1;
}

if($password != $confirm_password)
{
	echo "<font color=#ff0000>Passwords do not match.</font><br>";
	$form_error = 1;
}

if($form_error == 1)
{
	echo "Please <a href=javascript:history.back()>go back</a>
              and try again.";
	exit();
}

//----------------------------------------------------------------------------
//
//  They have supplied enough information to attempt to add them as a user.
//  First we want to make sure a user with that email / nickname doesn't
//  already exist in the system.  In other words, perform dupecheck.
//
//----------------------------------------------------------------------------

//
//  Connect to the database server.
//
$link = mysql_connect($db_host, $db_user, $db_pass)
   or die("Could not connect to the database.  Please try again later.");
mysql_select_db($db_name)
   or die("Could not select the database.  Please try again later.");

//
//  Perform the query.
//
$query = "SELECT * FROM users WHERE nick_name = '$nick_name' OR
          email = '$email' ";
$result = mysql_query($query)
   or die("Invalid database query.  Please notify the webmaster.");

extract(mysql_fetch_assoc($result), EXTR_PREFIX_ALL, "r");

if($r_id != "")
{
   mysql_free_result($result);
   mysql_close($link);
   die("<font color=#ff0000>
         A user already exists with that email address or nickname.
        </font>
	<br>Please <a href=javascript:history.back()>go back</a> and
        try again.");
}

//--------------------------------------------------------------------------
//
//	Okay no dupes, let's make this guy a user.
//
//--------------------------------------------------------------------------

//
//  Connect to the database server.
//
$link = mysql_connect($db_host, $db_user, $db_pass)
   or die("Could not connect to the database.  Please try again later.");
mysql_select_db($db_name)
   or die("Could not select the database.  Please try again later.");

//
//  Perform the query.
//
$password = md5($password);
$REMOTE_ADDR = $_SERVER['REMOTE_ADDR'];
$query = "INSERT INTO users ( email, nick_name, password, first_name, 
          last_name, created_ip, admin_access ) values
          ( '$email', '$nick_name', '$password', '$first_name', '$last_name',
	    '$REMOTE_ADDR', 0 ) "; 
$result = mysql_query($query)
   or die("Invalid database query.  Please notify the webmaster.");

//
//  Success, tell the user.
//
$page_title = "Registration Successful";
include("header.php");
echo "You have successfully registered.  You may now proceed to the
      <a href=login.php>Login Page</a>, or <a href=$return_url>return
      to your previous page</a>.";
include("footer.php");
?>
