<?php
/*****************************************************************************
 *
 *	newsdel.php
 *	by Nicholas Smith imnes@go.com
 *	Written 3/3/2003
 *
 *	Copyright (C) Nicholas Smith & The Pensacola Linux Users Group
 *
 *---------------------------------------------------------------------------
 *
 *	Delete a news from the library.
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

// Get the incoming variables. 
$id = $_GET["id"];
if($id == "")
{
	die("Invalid ID.");
}

$page_title="Deleting an Announcement";
include("header.php");

$confirmed = $_GET["confirmed"];

// Make sure we've confirmed the delete.
if($confirmed != "y")
{
	echo "
		<center>
		Are you sure you want to delete this announcement?<br>
		[ 
		<a href='newsdel.php?id=$id&confirmed=y'>Yes</a> | 
		<a href='javascript:history.back()'>No</a> ]
	  ";

}
else
{
// Delete the announcement 
$link = mysql_connect($db_host, $db_user, $db_pass)
	or die("Could not connect to the database.  Please try again later.");
mysql_select_db($db_name)
	or die("Could not select the database.  Please try again later.");
$query = "DELETE FROM news WHERE id = $id ";
$result = mysql_query($query)
	or die("Invalid database query.  Please notify the webmaster.");

// All done
echo "<center>Your announcement has been removed from the database.  <br>
	<a href=index.php>Return to the homepage.</a></center>"; 
}

include("footer.php");
?>
