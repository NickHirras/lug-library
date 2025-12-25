<?php
/*****************************************************************************
 *
 *	reviewchange.php
 *	by Nicholas Smith imnes@go.com
 *	Written 3/6/2003
 *
 *	Copyright (C) Nicholas Smith & The Pensacola Linux Users Group
 *
 *---------------------------------------------------------------------------
 *
 *	Make sure the user is logged in, and present a form for
 *	them to review a book.  The ISBN is incoming on the URL.
 *
 ****************************************************************************/

//
//	Make sure user is logged-in.
//
session_start();
require_once("include.php");

if($_SESSION['validated'] != 1)
{
	die("You must <a href=login.php?return_url=review.php?book_id=$book_id>
	     log-in</a> to review this book.");
}

//
//  	Capture incoming variables
//
$return_url = $_GET["return_url"];
$r_id = $_GET["r"];

if($r_id == "")
{
	die("No review id sent.");
}

//
//	Get the current values.
//
$link = mysql_connect($db_host, $db_user, $db_pass)
	or die("Could not connect to the database.  Please try again later.");
mysql_select_db($db_name)
	or die("Could not select the database.  Please try again later.");

$query = "SELECT * FROM reviews WHERE id = $r_id";
$result = mysql_query($query)
	or die("Invalid database query.  Please notify the webmaster.");

extract(mysql_fetch_assoc($result), EXTR_PREFIX_ALL, "r");

if($r_id == "")
{
	die("I could not locate that review.");
}

// 
//	Display the form to the user
//
$page_title = "Write a Book Review";
include("header.php");

for($i=0; $i<=5; $i = $i + 1)
{
	$stars_selected[$i] = " ";
}
$stars_selected[$r_stars] = " selected ";

for($i=0; $i<=2; $i = $i + 1)
{
    $recommend[$i] = " ";
}
$recommend[$r_recommended] = " selected ";

echo "
	<center>
	<form method=post action=reviewchange-2.php?return_url=$return_url>
	<table bgcolor=#eeeef0 border=0 cellpadding=2 cellspacing=0>
        <input type=hidden name=review_id value=$r_id>
	<tr>
		<th align=center bgcolor=#7777ff>
		<font color=#ffffff>Book Review</font>
	
	<tr>
		<th> &nbsp;

	<tr>
		<td>How well did you like this book?

	<tr>
		<td><select name=stars>
		<option $stars_selected[0] value=0>The worst book I ever read. (No Stars)
		<option $stars_selected[1] value=1>What a waste of my time. (1 Star)
		<option $stars_selected[2] value=2>I read it, but I wouldn't read it again. (2 Stars)
		<option $stars_selected[3] selected value=3>Average book, worth reading. (3 Stars)
		<option $stars_selected[4] value=4>Great book but some mistakes. (4 Stars)
		<option $stars_selected[5] value=5>This book was excellent. (5 Stars)
		</select>

	<tr>
		<td> &nbsp;

	<tr>
		<td>Would you recommend this book to a friend?

	<tr>
		<td><select name=recommend>
		<option $recommend[1] value=1>Yes
		<option $recommend[0] value=0>No
		</select>

	<tr>
		<td> &nbsp;

	<tr>
		<td>Please tell us what you liked and did not like about
			this book.  Be honest.
	
	<tr>
		<td><textarea name=review cols=50 rows=10>$r_review</textarea>

	<tr>
		<td> &nbsp;
	<tr>
		<td align=center><input type=submit value=Submit name=Submit>

	</table>
	</form>
	</center>
";

include("footer.php");

?>
