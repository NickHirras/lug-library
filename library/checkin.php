<?php
/*****************************************************************************
 *
 *	checkin.php
 *	by Nicholas Smith imnes@go.com
 *	Written 3/3/2003
 *
 *	Copyright (C) Nicholas Smith & The Pensacola Linux Users Group
 *
 *---------------------------------------------------------------------------
 *
 *	Check a book in.
 * 
 ****************************************************************************/

session_start();
require_once("include.php");

// Make sure we're logged-in.
if($_SESSION["validated"] != 1)
{
	die("You must be logged-in to access this page.");
}

// Check for incoming ownership_id (as id=)
$ownership_id = $_GET["id"];
if($ownership_id == "")
{
	die("Invalid id.");
}

// Include the top page template.
$page_title='Check Book In';
include('header.php');

//-------------------------------------------------------------
// Display a list of users so we can select who gets this book.
//-------------------------------------------------------------
$link = mysql_connect($db_host, $db_user, $db_pass)
	or die("Could not connect to the database.  Please try again later.");
mysql_select_db($db_name)
	or die("Could not select the database.  Please try again later.");

$query = "UPDATE ownership SET loaned_to = ' ' WHERE id = $ownership_id"; 
		

$result = mysql_query($query)
	or die("Invalid database query.  Please notify the webmaster.");

echo "The book has been checked in.  <a href=manage.php>Return to
	your book collection.</a>";

// Now the page footer template.
include('footer.php');
?>
