<?php
/*****************************************************************************
 *
 *      bookadd-2.php
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



//--------------------------------------------------------------------------
//
//	Add me as an ISBN owner, and find out if we need to catalog this
//	book or if it's already been entered.
//
//--------------------------------------------------------------------------

$user_id = $_SESSION["user_id"];
$isbn = $_GET["isbn"];

if($isbn=="")
{
	die("You must enter a valid ISBN.  It can usually be found on
	     the back cover of the book.  Do not enter any spaces or
	     dashes, just the numbers and letters.");
}

$link = mysql_connect($db_host, $db_user, $db_pass)
	or die("Could not connect to the database.  Please try again later.");
mysql_select_db($db_name)
	or die("Could not select the database.  Please try again later.");


//--------------------------------------------------------------------------
//
//	Attempt to pull down information from the Books-A-Million 
//	server.
//
//--------------------------------------------------------------------------

$bam_url = 'http://www.booksamillion.com/ncom/books?pid=' .  $isbn;
$bam_page = implode ('',
       file ("$bam_url"));
$bam_title = find_token($bam_page, "<TITLE>", "</TITLE>") ; 
$book_title = substr($bam_title, 0, 
	strpos($bam_title, ": Booksamillion.com"));
$book_authors = substr($book_title, 
	strpos($book_title, " by ")+4,
	100);
$book_title = substr($bam_title, 0, 
	strpos($bam_title, " by "));
$book_publisher = find_token($bam_page, "<B>Publisher:</B>",
		"/</NOBR>");
$book_copyright = find_token($bam_page, "<B>Date:</B>", "/");
$book_copyright = substr($book_copyright,
        strlen($book_copyright) - strpos($book_copyright, " ", 1) - 1,
        strlen($book_copyright));
$book_pages = find_token($bam_page, "<B>Page Count:</B>", "</");

$book_abstract = find_token($bam_page, "</TABLE>







", "


</FONT>
</FONT>

</TD>");

$bam_isbn = find_token($bam_page, "<B>ISBN:</B>", "/");

if($bam_isbn == "")
{
	$book_title = "";
	$book_authors = "";
	$book_publisher = "";
	$book_copyright = "";
	$book_pages = "";
}
else
{
	$book_title = trim($book_title);
	$book_authors = trim($book_authors);
	$book_publisher = trim($book_publisher);
	$book_copyright = trim($book_copyright);
	$book_pages = trim($book_pages);
}

//---------------------------------------------------------------------------
//
//	Display the form.
//
//---------------------------------------------------------------------------

$page_title = "Add a Book";
include("header.php");

	echo "
	<center>
	<form method=post action=bookadd-4.php>
	<input type=hidden name=isbn value=$isbn>

	<table bgcolor=#eeeef0 cellpadding=2 cellspacing=0 border=0>

	<tr>
		<th colspan=2 align=center bgcolor=#7777ff>
		<font color=#ffffff>Add a New Book</font>
		<br>

	<tr>
		<th align=right valign=top>Category:
		<td> 
	";

	categories_drop_list();
	echo "<br> 
	[ <a href=categoriesedit.php?return_url=";
	echo urlencode("bookadd-3.php?isbn=$isbn");
	echo ">
	Edit&nbsp;Categories</a> ] <br>
	";


	echo "
	<tr>
		<th colspan=2> &nbsp;

	<tr>
		<th align=right>Title:
		<td valign=top>
		<input type=text name=title size=40 maxlength=255
		 value=\"$book_title\">
	
	<tr>	
		<th align=right>Authors:<br>
		<font size=-1>(Last, First)</font>
		<td valign=top><input type=text name=author size=40 
		maxlength=255 value=\"$book_authors\">

	<tr>
		<th align=right>Publisher:
		<td valign=top><input type=text name=publisher size=40
		maxlength=255 value=\"$book_publisher\">

	<tr>
		<th align=right>Copyright Year:
		<td valign=top><input type=text name=copyright size=40
		maxlength=255 value=\"$book_copyright\">

	<tr>
		<th align=right>Page Count:
		<td valign=top><input type=text name=page_count size=40
		maxlength=255 value=\"$book_pages\">

	<tr>
		<th align=right colspan=2>&nbsp;

	<tr>
		<th align=left colspan=2>Abstract: 
		(Usually on the rear cover of the
		book)
		
	<tr>
		<td colspan=2 align=center>
		<textarea name=abstract cols=50 rows=10>$book_abstract</textarea>

	<tr>
		<td colspan=2>&nbsp;

	<tr>
		<th colspan=2 align=center>
		<input type=submit name=Add_Book value='Add Book'>
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
function categories_drop_list()
{

	// Include global varaibles, needed for the db connection.
	include("include.php");

	// Open the tag.
	echo "<select name=category>
		<option selected value=0>Please choose one...
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
		// --- Next 5 lines removed for asthetic reasons.
		// --- They make the categories no more than 40
		// --- chars long, truncating them and preceding
		// --- with elipses if needed ...
	 	//if(strlen($r_label) > 40)
		//{
		//	$r_label = "..." . 
                //          substr($r_label, strlen($r_label)-36, 36 );	
		//}	
		echo "
			<option value=$r_id>$r_label ";
	}


	// Close the tag.
	echo "
		</select>";

}

//********************** FUNCTION BY IMNES ************************//

function find_token($text, $before, $after)
{
	if(strpos($text, $before) == 0)
	{
		return "";
	}

	$start = strpos($text, $before);
	$start = $start + strlen($before);

	$end = strpos($text, $after, $start);
	$end = $end - $start;

	return(substr($text, $start, $end));
}

?>
