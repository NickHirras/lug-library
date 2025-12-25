<?php
/*****************************************************************************
 *
 *	checkout-2.php
 *	by Nicholas Smith imnes@go.com
 *	Written 3/3/2003
 *
 *	Copyright (C) Nicholas Smith & The Pensacola Linux Users Group
 *
 *---------------------------------------------------------------------------
 *
 *	Check a book out to a member.
 *
 ****************************************************************************/

session_start();
require_once("include.php");

// Make sure we're logged-in.
if($_SESSION["validated"] != 1)
{
	die("You must be logged-in to access this page.");
}

// Check for incoming vars 
$ownership_id = $_GET["o_id"];
if($ownership_id == "")
{
	die("Invalid id.");
}
$user_id = $_GET["u_id"];
if($user_id == "")
{
	die("Invalid id.");
}

// Include the top page template.
$page_title='Check Book Out to a Member';
include('header.php');

echo "
	<blockquote>
	<form method=post action=checkout-3.php>
		<input type=hidden name=owner_id value=$ownership_id>
		<input type=hidden name=user_id value=$user_id>
		When should the book be returned?<br>
		<input type=text name=due_date value=" . 
			//date('Y/m/d') . 
			date('Y/m/d', mktime (0, 0, 0, date("m")+1, date("d"), date("Y"))) .
		">
		<input type=submit value='Proceed ->'><br>
		<font size=-1><em>Date should be of the format
		year/month/day, for example March 23, 2000 should
		be entered as 2000/03/23.</em></font>
	</form>
	</blockquote>
	";

// Now the page footer template.
include('footer.php');
?>
