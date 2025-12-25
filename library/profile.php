<?php
/*****************************************************************************
 *
 *      profile.php
 *      by Nicholas Smith imnes@go.com
 *      Written 3/3/2003
 *
 *      Copyright (C) Nicholas Smith & The Pensacola Linux Users Group
 *
 *---------------------------------------------------------------------------
 *
 *	Allow the user to update his profile.  Allow administrators
 *	to delete user accounts.
 *
 ****************************************************************************/

require_once("include.php");
session_start();

// 
//	Get the variables we need.
//
$user_id = $_SESSION["user_id"];
$admin_access = $_SESSION["admin_access"];

//
//	Make sure the user is logged in.
//
if($_SESSION["validated"] != 1)
{
	die("You must <a href=login.php?return_url=profile.php>log-in</a>
		to view this page.");
}

//---------------------------------------------------------------------------
//
//	Pull the user information in from the database.
//
//---------------------------------------------------------------------------

// 
//  Connect to the database.
//
$link = mysql_connect($db_host, $db_user, $db_pass)
   or die("Could not connect to the database.  Please try again later.");
mysql_select_db($db_name) 
   or die("Could not select the database.  Please try again later.");

//
//  Perform query
//
$query = "SELECT * FROM users WHERE id = $user_id ";

$result = mysql_query($query) 
   or die("Invalid database query.  Please notify the webmaster.");

extract(mysql_fetch_assoc($result), EXTR_PREFIX_ALL, "r");

if($r_id == "") 
{
	// 
 	// 	Invalid Login
	//
	die("I could not find your profile in the database.");
}

//
// Show the form.
//

if($_SESSION["theme"] == "blue")
{
	$theme_blue_selected = " selected ";
}
else
{ 
	$them_original_selected = " selected ";
}

$page_title = "Update Your Profile";
include("header.php");

echo "If you wish to update your profile, make the changes below and
	then click on 'Update'.
	<P>

	<form method=POST action=profile-2.php?id=$user_id>
	<table align=center bgcolor=#eeeef0 border=0 cellpadding=2 cellspacing=0>
	<tr>
		<th bgcolor=#7777ff align=center colspan=2>
		<font color=#ffffff>My Profile</font>
		<br>

	<tr>
		<th align=right>Theme:
		<td><select name=template>
			<option $theme_original_selected value=original>
				Original Plain-Vanilla Theme
			<option $theme_blue_selected value=blue>
				Dark Blue Graphical Theme
		    </select>

	<tr>
		<th align=right>Email Address:
		<td><input type=text name=email value='$r_email' size=30>

	<tr>
		<th align=right>First Name:
		<td><input type=text name=first_name value='$r_first_name' size=30>

	<tr>
		<th align=right>Last Name:
		<td><input type=text name=last_name value='$r_last_name' size=30>

	<tr>
		<th align=right>Username:
		<td><input type=text name=nick_name value='$r_nick_name' size=30>

	<tr>
		<th align=right>Password:
		<td align=center>
			<a href=forgotpassword-3.php?u=$r_id&p=$r_password>
			Change Your Password</a>

	<tr>	<th colspan=2>&nbsp;

	<tr>	<th colspan=2 align=center><input type=submit value=Update>
		<br><br>

	</table>
	</form> 

	";

include("footer.php");


//
// Free up DB resources.
//
mysql_free_result($result);
mysql_close($link);


?>
