<?php
/*****************************************************************************
 *
 *      bookadd-2.php
 *      by Nicholas Smith imnes@go.com
 *      Written 3/3/2003
 *
 *      Copyright (C) Nicholas Smith & The Pensacola Linux Users Group
 *
 *---------------------------------------------------------------------------
 *
 *	Present the user a form for adding a book to the database.
 *
 ****************************************************************************/

require_once("include.php");
session_start();

//----------------------------------------------------------------------------
//
//	Make sure the user is logged in currently.
//
//----------------------------------------------------------------------------
if($_SESSION['validated'] != 1)
{
	die("You must <a href=login.php?return_url=bookadd.php>log-in</a>
             to access this page.");
}



//--------------------------------------------------------------------------
//
//	Add me as an ISBN owner, and find out if we need to catalog this
//	book or if it's already been entered.
//
//--------------------------------------------------------------------------

$skip_add=$_GET["skip_add"];
$user_id = $_SESSION["user_id"];
$isbn = $_POST["isbn"];

if($isbn=="")
{
	$isbn = $_GET["isbn"];
}

$isbn = str_replace("-", "", $isbn);
$isbn = str_replace(" ", "", $isbn);


if($isbn=="")
{
	die("You must enter a valid ISBN.  It can usually be found on
	     the back cover of the book.  Do not enter any spaces or
	     dashes, just the numbers and letters.");
}

$link = mysql_connect($db_host, $db_user, $db_pass)
	or die("Could not connect to the database.  Please try again later.");
mysql_select_db($db_name)
	or die("Could not select the database.  Please try again later.");

$query = "INSERT INTO ownership (isbn, owner) VALUES ('$isbn', $user_id) ";
$result = mysql_query($query)
	or die("Invalid database query.  Please notify the webmaster.");

if(mysql_affected_rows() < 1)
	die("Unable to process your request.");

// Check to see if the profile has been added.
$query = "SELECT id FROM books WHERE isbn = '$isbn' ";
$result = mysql_query($query)
	or die("Invalid database query.  Please notify the webmaster.");

extract(mysql_fetch_assoc($result), EXTR_PREFIX_ALL, "r");

if( ($r_id == "") || ($r_id == 0) )
{
	$book_info_exists = 0; 	
}
else
{
	$book_info_exists = 1;
}


//---------------------------------------------------------------------------
//
//	Display a form if needed.
//
//---------------------------------------------------------------------------

$page_title = "Add a Book";
include("header.php");

if($book_info_exists == 0)
{ 
	echo "
	<center>

	Now you need to input the details for this book.<br>
	<a href=bookadd-3.php?isbn=$isbn>Click here
	to proceed.</a>

	</center>
	     ";
}
else
{
	echo "<P><center>This ISBN has already been cataloged.  
		Your book has been successfully added.</center></P>";
}

include("footer.php");


?>
