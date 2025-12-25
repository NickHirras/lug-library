<?php
/*****************************************************************************
 *
 *      review.php
 *      by Nicholas Smith imnes@go.com
 *      Written 3/6/2003
 *
 *      Copyright (C) Nicholas Smith & The Pensacola Linux Users Group
 *
 *---------------------------------------------------------------------------
 *
 *      Make sure the user is logged in, and present a form for
 *      them to review a book.  The ISBN is incoming on the URL.
 *
 ****************************************************************************/

//
//      Make sure user is logged-in.
//
session_start();
require_once("include.php");

$isbn = $_GET["isbn"];

if($_SESSION['validated'] != 1)
{
        die("You must <a href=login.php?return_url=review.php?book_id=$book_id>
             log-in</a> to review this book.");
}

//
//      Capture incoming variables
//
$return_url = $_GET["return_url"];
$isbn = $_GET["isbn"];

$stars = $_POST["stars"];
$recommend = $_POST["recommend"];
$review = addslashes($_POST["review"]);

if(($stars=="") || ($recommend=="") || ($review=="") || ($isbn=="")) 
{
	die("All of the fields must be filled in.<br>
		Please <a href=javascript:history.back()>go back</a> and
		try again.");
}


//
//	Save the review to the database.
//
$user_id = $_SESSION["user_id"];

$link = mysql_connect($db_host, $db_user, $db_pass)
	or die("Could not connect to the database.  Please try again later.");
mysql_select_db($db_name)
	or die("Could not select the database.  Please try again later.");

$query = "INSERT INTO reviews (user_id, isbn, recommended, stars, review)
		values ($user_id, '$isbn', $recommend, $stars, '$review') ";

$result = mysql_query($query)
	or die("Invalid database query.  Please notify the webmaster.");

$page_title="Review Successfully Submitted";
include("header.php");
echo "<center>Your review was added successfully.<br>
	<a href=$return_url>Return to your previous page.</a></center>";
include("footer.php");

mysql_free_result($result);
mysql_close($link);

?>
