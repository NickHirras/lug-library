<?php
/*****************************************************************************
 *
 *      forgotpassword-3.php
 *      by Nicholas Smith imnes@go.com
 *      Written 3/3/2003
 *
 *      Copyright (C) Nicholas Smith & The Pensacola Linux Users Group
 *
 *---------------------------------------------------------------------------
 *
 *	Verify the incoming link data and if valid allow the user to
 *	change his/her password.
 *
 ****************************************************************************/

require_once("include.php");

//
//  Validate data
//
$user_id = $_GET["u"];
$password = $_GET["p"];

if( ($user_id=="") || ($password=="") ) 
{
   die("<font color=#ff0000>
        Incomplete link, try again.  Your link should contain a valid
        u= and p=.</font>");
}


// 
// Connect to the database
//
$link = mysql_connect($db_host, $db_user, $db_pass)
   or die("Could not connect to the database.  Please try again later.");
mysql_select_db($db_name)
   or die("Could not select the database. Please try again later.");


// 
//  Perform Query
//
$query = "SELECT password FROM users WHERE id = $user_id ";
$result = mysql_query($query)
   or die("Invalid database query.  Please notify the webmaster.");

extract(mysql_fetch_assoc($result), EXTR_PREFIX_ALL, "r");

if($r_password != $password)
{
	die("Your password has already been changed or your account
             has been deleted.");
}


//
// It's all good, prompt them for a new password.
//
$page_title = "Change Your Password";
include("header.php");
echo "
	<center>
	<form method=post action=forgotpassword-4.php>
	<table bgcolor=#eeeef0 border=0 cellpadding=2 cellspacing=0>
	
	<tr>
	  <th align=right>New Password: 
	  <td><input type=password name=new_password size=30 maxlength=255>
	<tr>
	  <th align=right>Confirm New Password:
	  <td><input type=password name=new_password_confirm size=30 
               maxlength=255>
	<tr>
	  <th colspan=2>&nbsp;
	<tr>
	  <td colspan=2 align=center valign=middle>
	  <input type=submit name=Update value=Update>

	<input type=hidden name=user_id value=$user_id>
	<input type=hidden name=old_password value=$password>

	</table>
	</form>
	</center>

	";
include("footer.php");
?>
