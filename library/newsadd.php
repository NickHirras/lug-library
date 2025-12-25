<?php
/*****************************************************************************
 *
 *	newsadd.php
 *	by Nicholas Smith imnes@go.com
 *	Written 3/3/2003
 *
 *	Copyright (C) Nicholas Smith & The Pensacola Linux Users Group
 *
 *---------------------------------------------------------------------------
 *
 *	Display a form to add a news article.
 *
 ****************************************************************************/

session_start();
require_once("include.php");

if($_SESSION["admin_access"] != 1)
{
	die("You must be an administrator to access this page.");
}

// Include the top page template.
$page_title='Add a New Announcement';
include('header.php');


echo "<blockquote>
	";


echo "
	<center>
	<form method=post action=newsadd-2.php>
	
	<table bgcolor=#eeeef0 border=0 cellpadding=3 cellspacing=0>
	
	<tr>
		<th colspan=2 bgcolor=#7777ff>
		<font color=#ffffff>Announcement</font>

	<tr>
		<th align=right valign=top>Headline:
		<td><input type=text name=headline size=30 maxlength=128>

	<tr>
		<th align=right valign=top>Full Story:
		<td><textarea name=story cols=30 rows=10></textarea>

	<tr>
		<th colspan=2>
		<br>
		<input type=submit value='Add Announcement'>
		<br><br>

	</table>

	</form>
	</center>
	";

echo "</blockquote>";

// Now the page footer template.
include('footer.php');
?>
