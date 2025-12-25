<?php
/*****************************************************************************
 *
 *      bookedit-2.php
 *      by Nicholas Smith imnes@go.com
 *      Written 3/3/2003
 *
 *      Copyright (C) Nicholas Smith & The Pensacola Linux Users Group
 *
 *---------------------------------------------------------------------------
 *
 *	Update book to the database.
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
if($_SESSION['validated']!=1)
{
	die("You have to <a href=login.php?return_url=addbook.php>log-in</a>
	     before you can view this page.");
}

$user_id = $_SESSION['user_id'];
$category = $_POST["category"];
$title = addslashes(strtoupper($_POST["title"]));
$isbn = addslashes($_POST["isbn"]);
$author = addslashes(strtoupper($_POST["author"]));
$publisher = addslashes(strtoupper($_POST["publisher"]));
$copyright = addslashes($_POST["copyright"]);
$page_count = addslashes($_POST["page_count"]);
$abstract = addslashes($_POST["abstract"]);
$old_isbn = $_POST["old_isbn"];
$id = $_POST["id"];

$form_error = 0;

if($category == 0)
{
	echo "<font color=#ff0000>
		You must select a category.
		</font>";
	$form_error = 1;
}


if($title == "")
{
	echo "<font color=#ff0000>
		You must enter a title.
		</font>";
	$form_error = 1;

}

if( ($isbn == "") || (strpos($isbn, " ")) || (strpos($isbn, "-")) )
{
	echo "<font color=#ff0000>
		You must enter a valid ISBN.  It should not contain any spaces or
		dashes.  It can usually be found on the back of the book.</font>";
	$form_error = 1;
}


if($author == "")
{
	echo "<font color=#ff0000>
		You must specify name the author(s).  The names should appear as
		last name, first name and multiple authors seperated with an 
		ampersand.  </font>";
	$form_error = 1;
}

if($publisher == "")
{
	echo "<font color=#ff0000>
		You must specify the publisher.</font>";
	$form_error = 1;
}

if($copyright == "")
{
	echo "<font color=#ff0000>
		You must enter a valid copyright year.  For example, 1999.</font>";
	$form_error = 1;
}

if($page_count == "")
{
	echo "<font color=#ff0000>
		You must enter a page count.  Just flip to the last numbered page in
		the book and use that number.</font>";
	$form_error = 1;
}

if($abstract == "")
{
	echo "<font color=#ff0000>
		You must enter an abstract.  You could enter the text that appears on
		the back cover of the book describing it, or copy text from a website
		about the book.  Or even just write your own if you have read the book.
		</font>";
	$form_error = 1;
}



if($form_error == 1)
{
	echo "Please <a href=javascript:history.back()>go back</a>
              and try again.";
	exit();
}


//--------------------------------------------------------------------------
//
//	Attempt to add the book to the system.	
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
$REMOTE_ADDR = $_SERVER['REMOTE_ADDR'];
$query = "UPDATE books SET
		category = $category, 
		title = '$title',
		authors = '$author',
		isbn = '$isbn',
		publisher = '$publisher',
		copyright = '$copyright',
		page_count = $page_count,
		abstract = '$abstract' 
		WHERE id = '$id' ";

$result = mysql_query($query)
   or die("Invalid database query.  Please notify the webmaster.");

// Now update the ISBN if necessary in the ownership tables.
if($isbn != $old_isbn)
{
	$query = "UPDATE ownership SET isbn = '$isbn' WHERE isbn = '$old_isbn'";
	$result = mysql_query($query)
		or die("Invalid database query.  Please notify the webmaster.");
}


//
//  Success, tell the user.
//
$page_title = "Book Updated Successfully.";
include("header.php");

echo "<center>
	The book has been updated successfully.  You may now return
	to <a href=manage.php>your collection</a>.
	</center>
	";


include("footer.php");
?>
