<?php
/*****************************************************************************
 *
 *	review.php
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

$isbn = $_GET["isbn"];

if($_SESSION['validated'] != 1)
{
	die("You must <a href=login.php?return_url=review.php?book_id=$book_id>
	     log-in</a> to review this book.");
}

//
//  	Capture incoming variables
//
$return_url = $_GET["return_url"];
$isbn = $_GET["isbn"];

// 
//	Display the form to the user
//
$page_title = "Write a Book Review";
include("header.php");

echo "
	<center>
	<form method=post action=review-2.php?isbn=$isbn&return_url=$return_url>
	<table bgcolor=#eeeef0 border=0 cellpadding=2 cellspacing=0>

	<tr>
		<th align=center bgcolor=#7777ff>
		<font color=#ffffff>Book Review</font>
	
	<tr>
		<th> &nbsp;

	<tr>
		<td>How well did you like this book?

	<tr>
		<td><select name=stars>
		<option value=0>The worst book I ever read. (No Stars)
		<option value=1>What a waste of my time. (1 Star)
		<option value=2>I read it, but I wouldn't read it again. (2 Stars)
		<option selected value=3>Average book, worth reading. (3 Stars)
		<option value=4>Great book but some mistakes. (4 Stars)
		<option value=5>This book was excellent. (5 Stars)
		</select>

	<tr>
		<td> &nbsp;

	<tr>
		<td>Would you recommend this book to a friend?

	<tr>
		<td><select name=recommend>
		<option selected value=1>Yes
		<option value=0>No
		</select>

	<tr>
		<td> &nbsp;

	<tr>
		<td>Please tell us what you liked and did not like about
			this book.  Be honest.
	
	<tr>
		<td><textarea name=review cols=50 rows=10></textarea>

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
