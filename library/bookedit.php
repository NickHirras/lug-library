<?php
/*****************************************************************************
 *
 *      bookedit-2.php
 *      by Nicholas Smith imnes@go.com
 *      Written 3/3/2003
 *
 *      Copyright (C) Nicholas Smith & The Pensacola Linux Users Group
 *
 *---------------------------------------------------------------------------
 *
 *	Present the user a form for updating a book to the database.
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

//--------------------------------------------------------------------------
//
//	Catch the incoming variables.
//
//--------------------------------------------------------------------------
$book_isbn = $_GET["isbn"];

//---------------------------------------------------------------------------
//
//	Pull  the existing data from the database.
//
//---------------------------------------------------------------------------
$link = mysql_connect($db_host, $db_user, $db_pass)
	or die("Could not connect to the database.  Please try again later.");
mysql_select_db($db_name)
	or die("Could not select the database.  Please try again later.");

$query = "SELECT * FROM books WHERE isbn = '$book_isbn' "; 
$result = mysql_query($query)
	or die("Invalid database query.  Please notify the webmaster.");

extract(mysql_fetch_assoc($result), EXTR_PREFIX_ALL, "r");

$r_title = ($r_title);
$r_authors = ($r_authors);
$r_publisher = ($r_publisher);
$r_abstract = ($r_abstract);


//---------------------------------------------------------------------------
//
//	Display a form if needed.
//
//---------------------------------------------------------------------------

$page_title = "Edit a Book";
include("header.php");

	echo "
	<center>
	<form method=post action=bookedit-2.php>

	<table bgcolor=#eeeef0 cellpadding=2 cellspacing=0 border=0>
	<input type=hidden name=id value=$id>
	<input type=hidden name=old_isbn value=$book_isbn>

	<tr>
		<th colspan=2 align=center bgcolor=#7777ff>
		<font color=#ffffff>Edit a Book</font>
		<br>

	<tr>
		<th align=right valign=top>Category:
		<td> 
	";

	categories_drop_list("$r_category");
	echo "<br> 
	[ <a href=categoriesedit.php?return_url=bookedit.php?isbn=$book_isbn>
	Edit&nbsp;Categories</a> ] <br>
	";


	echo "
	<tr>
		<th colspan=2> &nbsp;

	<tr>
		<th align=right>Title:
		<td valign=top>
		<input type=text name=title size=40 maxlength=255 value=\"$r_title\">
	
	<tr>	
		<th align=right>Authors:<br>
		<font size=-1>(Last, First)</font>
		<td valign=top><input type=text name=author size=40 
		maxlength=255 value=\"$r_authors\">

	<tr>
		<th align=right>ISBN:
		<td valign=top><input type=text name=isbn size=20
		maxlength=50 value=\"$r_isbn\">

	<tr>
		<th align=right>Publisher:
		<td valign=top><input type=text name=publisher size=40
		maxlength=255 value=\"$r_publisher\">

	<tr>
		<th align=right>Copyright Year:
		<td valign=top><input type=text name=copyright size=40
		maxlength=255 value=\"$r_copyright\">

	<tr>
		<th align=right>Page Count:
		<td valign=top><input type=text name=page_count size=40
		maxlength=255 value=\"$r_page_count\">

	<tr>
		<th align=right colspan=2>&nbsp;

	<tr>
		<th align=left colspan=2>Abstract: 
		(Usually on the rear cover of the
		book)
		
	<tr>
		<td colspan=2 align=center>
		<textarea name=abstract cols=50 rows=10>$r_abstract</textarea>

	<tr>
		<td colspan=2>&nbsp;

	<tr>
		<th colspan=2 align=center>
		<input type=submit value='Update Book'>
	";


	echo "
	</table>
	
	</form>
	</center>
	     ";

include("footer.php");


//===========================================================================
//
//	Build a drop-list of book categories.
//
//===========================================================================
function categories_drop_list($highlight_item)
{

	// Include global varaibles, needed for the db connection.
	include("include.php");

	// Open the tag.
	echo "<select name=category>
		<option ";
	
	if($highlight_item == "")
	{
		echo "selected";
	}

	echo " value=0>Please choose one...
		";

	// Pull in the categories from the database.
	$link = mysql_connect($db_host, $db_user, $db_pass)
		or die("Could not connect to the database.  Please try again  
			later.");

	mysql_select_db($db_name)
		or die("Could not select the database.  Please try again
			later");

	$query = "SELECT * FROM categories ORDER BY label ";
	
	$result = mysql_query($query);

	while($r = mysql_fetch_array($result))
	{
		extract($r, EXTR_PREFIX_ALL, "r");
	//--- Resize large entries to 40 chars max, this looked funky
	//--- so I removed it for asthetic reasons.  Just uncomment the
	//--- next 5 lines to make it happen again.
	//	if(strlen($r_label) > 40)
	//	{
	//		$r_label = "..." . 
        //                substr($r_label, strlen($r_label)-36, 36 );	
	//	}	
		echo "
			<option ";

		if($highlight_item == $r_id)
		{
			echo "selected";
		}

		echo " value=$r_id>$r_label ";
	}


	// Close the tag.
	echo "
		</select>";

}

?>
