<?php
/*****************************************************************************
 *
 *      profile-2.php
 *      by Nicholas Smith imnes@go.com
 *      Written 3/3/2003
 *
 *      Copyright (C) Nicholas Smith & The Pensacola Linux Users Group
 *
 *---------------------------------------------------------------------------
 *
 *	Update user profile in the database.
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
$template = $_POST["template"];
$id = $_GET["id"];
$form_error = 0;

if($nick_name == "") $nick_name = " ";
if($first_name == "") $first_name = " ";
if($last_name == "") $last_name = " ";

if($return_url == "")
{
	$return_url="login.php";
}

if($template == "")
{
	$template = 'original';
}

if($email == "")
{
	echo "<font color=#ff0000>You must enter a valid email address.</font>
              <br>";
	$form_error = 1;
}

if($id == "")
{
	echo "<font color=#ff0000>Your ID was not given.  Please 
		try again.</font><br>";
	$form_error = 1;
}

if($id != $_SESSION["user_id"])
{
	if($_SESSION["admin_access"] != 1)
	{
		echo "<font color=#ff0000>You must be an administrator
			to update another users profile.</font><br>";
		$form_error = 1;
	}
}

if($form_error == 1)
{
	echo "Please <a href=javascript:history.back()>go back</a>
              and try again.";
	exit();
}


//--------------------------------------------------------------------------
//
//	Perform the update.
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
$query = "UPDATE users SET
		email = '$email',
		nick_name = '$nick_name',
		first_name = '$first_name',
		last_name = '$last_name',
		theme = '$template' 
		WHERE id = $id";

$result = mysql_query($query)
   or die("Invalid database query.  Please notify the webmaster.");

//
//  Success, tell the user.
//
$page_title = "Update Successful";
include("header.php");
echo "Profile updated successfully.  You must log-out and log back in
	before the changes you made will take effect."; 
include("footer.php");
?>
