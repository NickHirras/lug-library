<?php
/*****************************************************************************
 *
 *      reviewchange-2.php
 *      by Nicholas Smith imnes@go.com
 *      Written 3/6/2003
 *
 *      Copyright (C) Nicholas Smith & The Pensacola Linux Users Group
 *
 *---------------------------------------------------------------------------
 *
 *       Update a review   
 * 
 ****************************************************************************/

//
//      Make sure user is logged-in.
//
session_start();
require_once("include.php");

if($_SESSION['validated'] != 1)
{
        die("You must <a href=login.php?return_url=review.php?book_id=$book_id>
             log-in</a> to review this book.");
}

//
//      Capture incoming variables
//
$return_url = $_GET["return_url"];
$review_id = $_POST["review_id"];

$stars = $_POST["stars"];
$recommend = $_POST["recommend"];
$review = addslashes($_POST["review"]);

if(($stars=="") || ($recommend=="") || ($review=="")) 
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

$query = "UPDATE reviews SET
	     user_id = $user_id,
	     stars = $stars,
	     recommended = $recommend,
	     review = '$review'
	   WHERE id = $review_id ";
	   
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
