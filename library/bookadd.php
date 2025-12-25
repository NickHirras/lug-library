<?php
/*****************************************************************************
 *
 *      bookadd.php
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


//---------------------------------------------------------------------------
//
//	Display a form.
//
//---------------------------------------------------------------------------

$page_title = "Add a Book";
include("header.php");

	echo "
	<center>
	<form method=post action=bookadd-2.php>

	<table bgcolor=#eeeef0 cellpadding=2 cellspacing=0 border=0>

	<tr>
		<th colspan=2 align=center bgcolor=#7777ff>
		<font color=#ffffff>Add a New Book</font>

	<tr>
		<td colspan=2>&nbsp;

	<tr>
		<td colspan=2 align=center>
		<font size=-1><em>
			<a href=help.html#noisbn target=_blank>
			My book doesn't have an ISBN
			</a>
		</em></font>  

	<tr>
		<td colspan=2>&nbsp;

	<tr>
		<th align=right>ISBN:<br>
		<font size=-1>(No spaces or dashes)</font>
		<td valign=top>
		<input type=text name=isbn size=40 maxlength=255>

	<tr>
		<td colspan=2>&nbsp;

	<tr>
		<th colspan=2 align=center>
		<input type=submit name=Add_Book value='Next ->'>
		<br><br>
	";


	echo "
	</table>
	
	</form>
	</center>
	     ";


include("footer.php");


?>
