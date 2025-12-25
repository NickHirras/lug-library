<?php
/*****************************************************************************
 *
 *	login.php
 *	by Nicholas Smith imnes@go.com
 *	Written 3/3/2003
 *
 *	Copyright (C) Nicholas Smith & The Pensacola Linux Users Group
 *
 *---------------------------------------------------------------------------
 *
 *	Display a login form to the user.  If someone is already logged
 *	in, abandon their session.  If no return_url was specified, make
 *	a default to index.php.
 *
 ****************************************************************************/

session_start();
require_once("include.php");

if(isset($_SESSION["admin_access"]))
{
	$admin_access = $_SESSION["admin_access"];
}
else
{
	$admin_access = 0;
}

// Include the top page template.
$page_title='Homepage / Announcements';
include('header.php');


echo "<blockquote>
	";
// Pull in the news announcements, newest one's first.
$link = mysql_connect($db_host, $db_user, $db_pass)
	or die("Could not connect to the database.  Please try again later.");
mysql_select_db($db_name)
	or die("Could not select the database.  Please try again later.");

$query = "SELECT id, headline, story, DATE_FORMAT(posted, '%M %D, %Y') 
		as date_posted FROM news ORDER BY posted DESC ";

$result = mysql_query($query)
	or die("Invalid database query.  Please notify the webmaster.");

$num_results = 0;

while($r = mysql_fetch_array($result)) 
{
	extract($r, EXTR_PREFIX_ALL, "r");

	if($num_results > 0)
	{
		echo "<hr size=1 width=50%>";
	}

	$r_story = nl2br($r_story);
	echo "<strong>$r_headline</strong><br>
		<font size=-1><em>$r_date_posted</em></font><br>
		$r_story<br>
		";

	if($admin_access == 1)
	{
		echo "<center>
			[ <a href=newsedit.php?id=$r_id>Edit</a> |
 			<a href=newsdel.php?id=$r_id>Remove</a> ]
		      </center>
			";
	}

	$num_results = $num_results + 1;		
} 

if($admin_access == 1)
{
	echo "<br><center>
		[ <a href=newsadd.php>Add a New Announcement</a> ]
	      </center>";
}

if($num_results == 0)
{
	echo "No current announcements.";
}

echo "</blockquote>";

// Now the page footer template.
include('footer.php');
?>
