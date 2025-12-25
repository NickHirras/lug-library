<?php
/*****************************************************************************
 *
 *	useradmin.php
 *	by Nicholas Smith imnes@go.com
 *	Written 3/3/2003
 *
 *	Copyright (C) Nicholas Smith & The Pensacola Linux Users Group
 *
 *---------------------------------------------------------------------------
 *
 *	Manage user accounts.
 *
 ****************************************************************************/

session_start();
require_once("include.php");

// Make sure we're logged-in.
if($_SESSION["validated"] != 1)
{
	die("You must be logged-in to access this page.");
}

if($_SESSION["admin_access"] != 1)
{
	die("You must be an administrator to view this page.");
}


// Include the top page template.
$page_title='User Accounts';
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
	<P><strong>User List:
	</strong>
	<P>
	<OL>
	";

$num_results = 0;

while($r = mysql_fetch_array($result))
{
	extract($r, EXTR_PREFIX_ALL, "r");
	$num_results = $num_results + 1;

	echo "<LI>
		$r_nick_name ($r_email) ";

	if($r_first_name . $r_last_name != "")
	{
		echo "a.k.a. $r_first_name $r_last_name ";
	}

	echo "
		<a href=useredit.php?id=$r_id>
		<img border=0 src=icon_pencil.gif alt='Edit Profile'></a>
		<a href=userdel.php?id=$r_id>
		<img border=0 src=icon_trashcan.gif alt='Delete User'></a>
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
