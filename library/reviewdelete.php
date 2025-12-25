<?php
/*****************************************************************************
 *
 *	reviewdelete.php
 *	by Nicholas Smith imnes@go.com
 *	Written 3/3/2003
 *
 *	Copyright (C) Nicholas Smith & The Pensacola Linux Users Group
 *
 *---------------------------------------------------------------------------
 *
 *	Delete a review from the library.
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
$r_id = $_GET["r"];
if($r_id == "")
{
	die("Invalid review ID.");
}

$page_title="Deleting a Review";
include("header.php");

$return_url = $_GET["return_url"];
$confirmed = $_GET["confirmed"];

// Make sure we've confirmed the delete.
if($confirmed != "y")
{
	echo "
		<center>
		Are you sure you want to delete this review?<br>
		[ 
		<a href='reviewdelete.php?r=$r_id&confirmed=y&return_url=$return_url'>Yes</a> | 
		<a href='javascript:history.back()'>No</a> ]
	  ";

}
else
{
// Delete the book
$link = mysql_connect($db_host, $db_user, $db_pass)
	or die("Could not connect to the database.  Please try again later.");
mysql_select_db($db_name)
	or die("Could not select the database.  Please try again later.");
$query = "DELETE FROM reviews WHERE id = $r_id ";
$result = mysql_query($query)
	or die("Invalid database query.  Please notify the webmaster.");

// All done
echo "<center>Your review has been removed from the database.  <br>
	<a href=$return_url>Return to your previous page.</a></center>"; 
}

include("footer.php");
?>
