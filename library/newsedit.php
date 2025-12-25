<?php
/*****************************************************************************
 *
 *	newsedit.php
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

$id = $_GET["id"];

// Pull data in from database.
        $link = mysql_connect($db_host, $db_user, $db_pass)
                or die("Could not connect to the database.
                                Please try again later.");
        mysql_select_db($db_name)
                or die("Could not select the database.
                        Please try again later.");

	$query = "SELECT * FROM news WHERE id = $id";

        $result = mysql_query($query)
                or die("Invalid database query.  Please notify the webmaster.");

	extract(mysql_fetch_assoc($result), EXTR_PREFIX_ALL, "r");

	if($r_id == "")
	{
		die ("I could not find that news article.");
	}

	$r_headline = str_replace("\"", '&quot;', "$r_headline");
	$r_story = ("$r_story");

// Include the top page template.
$page_title='Updating Announcement';
include('header.php');


echo "<blockquote>
	";


echo "
	<center>
	<form method=post action=newsedit-2.php?id=$id>
	
	<table bgcolor=#eeeef0 border=0 cellpadding=3 cellspacing=0>
	
	<tr>
		<th colspan=2 bgcolor=#7777ff>
		<font color=#ffffff>Announcement</font>

	<tr>
		<th align=right valign=top>Headline:
		<td><input type=text name=headline value=\"$r_headline\"
			size=30 maxlength=128>

	<tr>
		<th align=right valign=top>Full Story:
		<td><textarea name=story cols=30 rows=10>$r_story</textarea>

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
