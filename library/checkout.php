<?php
/*****************************************************************************
 *
 *	checkout.php
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

// Check for incoming ownership_id (as id=)
$ownership_id = $_GET["id"];
if($ownership_id == "")
{
	die("Invalid id.");
}

// Include the top page template.
$page_title='Check Book Out to a Member';
include('header.php');

//-------------------------------------------------------------
// Display a list of users so we can select who gets this book.
//-------------------------------------------------------------
$link = mysql_connect($db_host, $db_user, $db_pass)
	or die("Could not connect to the database.  Please try again later.");
mysql_select_db($db_name)
	or die("Could not select the database.  Please try again later.");

$query = "SELECT * FROM users ORDER BY nick_name ";

$result = mysql_query($query)
	or die("Invalid database query.  Please notify the webmaster.");

echo "<blockquote>
	<P><strong>Please choose a member who you wish to loan this book to:
	</strong>
	<P>
	<OL>
	";

$num_results = 0;

while($r = mysql_fetch_array($result))
{
	extract($r, EXTR_PREFIX_ALL, "r");
	$num_results = $num_results + 1;

	echo "<LI><a href=checkout-2.php?o_id=$ownership_id&u_id=$r_id>
		$r_nick_name ($r_email) ";

	if($r_first_name . $r_last_name != "")
	{
		echo "a.k.a. $r_first_name $r_last_name ";
	}

	echo "</a>
		";
}

echo "</OL>
	</blockquote>";


if($num_results == 0)
{
	echo "There are no members signed-up to the library!";
}

// Now the page footer template.
include('footer.php');
?>
