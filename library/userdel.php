<?php
/*****************************************************************************
 *
 *	userdel.php
 *	by Nicholas Smith imnes@go.com
 *	Written 3/3/2003
 *
 *	Copyright (C) Nicholas Smith & The Pensacola Linux Users Group
 *
 *---------------------------------------------------------------------------
 *
 *	Delete a user.
 *
 ****************************************************************************/

// Lose their old session if they were logged in.
session_start();
require_once("include.php");

// Are we logged in?
if($_SESSION["validated"] != 1)
{
	die("You are not logged-in.");
}

if($_SESSION["admin_access"] != 1)
{
	die("You must be an administrator to view this page.");
}
// Get the incoming variables. 
$user_id = $_GET["id"];
$confirmed = $_GET["confirmed"];
if($user_id == "")
{
	die("Invalid ID.");
}

$page_title="Deleting a User";
include("header.php");

// Make sure we've confirmed the delete.
if($confirmed != "y")
{
	echo "
		<center>
		Are you sure you want to delete this user?<br>
		[ 
		<a href='userdel.php?id=$user_id&confirmed=y'>Yes</a> | 
		<a href='javascript:history.back()'>No</a> ]
	  ";

}
else
{
// Delete the user 
$link = mysql_connect($db_host, $db_user, $db_pass)
	or die("Could not connect to the database.  Please try again later.");
mysql_select_db($db_name)
	or die("Could not select the database.  Please try again later.");
$query = "DELETE FROM users WHERE id = $user_id ";
$result = mysql_query($query)
	or die("Invalid database query.  Please notify the webmaster.");

// All done
echo "<center>The user has been removed from the database.  <br>
	<a href=useradmin.php>Return to the accounts list.</a></center>"; 
}

include("footer.php");
?>
