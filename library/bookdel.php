<?php
/*****************************************************************************
 *
 *	bookdel.php
 *	by Nicholas Smith imnes@go.com
 *	Written 3/3/2003
 *
 *	Copyright (C) Nicholas Smith & The Pensacola Linux Users Group
 *
 *---------------------------------------------------------------------------
 *
 *	Delete a book from the library.
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
$owner_id = $_GET["o_id"];
$user_id = $_SESSION["user_id"];
$confirmed = $_GET["confirmed"];
if($owner_id == "")
{
	die("Invalid ownership ID.");
}

$page_title="Deleting a Book";
include("header.php");

// Make sure we've confirmed the delete.
if($confirmed != "y")
{
	echo "
		<center>
		Are you sure you want to delete this book?<br>
		[ 
		<a href='bookdel.php?o_id=$owner_id&confirmed=y'>Yes</a> | 
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
$query = "DELETE FROM ownership WHERE id = $owner_id ";
$result = mysql_query($query)
	or die("Invalid database query.  Please notify the webmaster.");

// All done
echo "<center>Your book has been removed from the database.  <br>
	<a href=manage.php>Return to your collections.</a></center>"; 
}

include("footer.php");
?>
