<?php
/*****************************************************************************
 *
 *	categoriesedit.php
 *	by Nicholas Smith imnes@go.com
 *	Written 3/3/2003
 *
 *	Copyright (C) Nicholas Smith & The Pensacola Linux Users Group
 *
 *---------------------------------------------------------------------------
 *
 *	Allow a logged-in user to edit / add / remove categories to
 *	the library.
 *
 ****************************************************************************/

session_start();
require_once("include.php");

// Find out if we have a return_url, default to index.php 
$return_url = $_GET['return_url'];
if($return_url == '')  
{
	$return_url = "index.php"; 
}

// Check for incoming vars
$mcat = $_POST["mcat"];
$new_cat = $_POST["cat_name"];


if($new_cat == "")
{
	die("You must provide a name for the new category.");
}



// Include the top page template.
$page_title='Add a Category';
include('header.php');


// Attempt to add it.
if($mcat != "")
{
	$mcat = $mcat . " -- ";
}
$cat = strtoupper(addslashes($mcat . $new_cat));
$query = "INSERT INTO categories (label) values ('$cat') ";

$link = mysql_connect($db_host, $db_user, $db_pass)
	or die("Could not connect to the database.  Please try again later.");

mysql_select_db($db_name)
	or die("Could not select the database.  Please try again later.");

$result = mysql_query($query)
	or die("Invalid database query.  Please notify the webmaster.");

echo "Category successfully added. <br>
	 <a href=$return_url>Return to your previous page.</a>";


// Now the page footer template.
include('footer.php');

?>
