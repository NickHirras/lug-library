<?php
/*****************************************************************************
 *
 *	search-2.php
 *	by Nicholas Smith imnes@go.com
 *	Written 3/3/2003
 *
 *	Copyright (C) Nicholas Smith & The Pensacola Linux Users Group
 *
 *---------------------------------------------------------------------------
 *
 *	Display search results.
 *
 ****************************************************************************/

// Lose their old session if they were logged in.
session_start();
require_once("include.php");

// Check for an incoming query q=
$query = $_GET["q"];
if($query == "")
{
	die("You must enter a search query.");
}


// Include the top page template.
$page_title="Search Results for $query";
include('header.php');

// Display the Search  form.
echo "<!---- Search Form ----> 
      <form method=get action=search-2.php>      
      <center>
      <table border=0 cellpadding=3 cellspacing=0 bgcolor=#eeeef0>
      <tr><th align=center bgcolor=#7777ff>
      <font color=#ffffff>Search the Library Again</font>
      <tr><th>&nbsp;
      <tr>
         <th align=left valign=top>Enter part of a title, isbn, or authors name:<br>
         <input type=text name=q size=50 maxlength=255 value=\"$query\">
      <tr>
         <th>&nbsp;
      <tr>
	 <td align=center><input type=submit value=Search>
	<br><br>
      </table>
      </center>
      </form>";


//========================== Search Results ================================//


$q = addslashes($query);

$link = mysql_connect($db_host, $db_user, $db_pass)
	or die("Could not connect to the database.  Please try again later.");

mysql_select_db($db_name)
	or die("Could not select the database.  Please try again later.");

$query = "SELECT isbn, title, authors, abstract, label    
		FROM books INNER JOIN categories 
		ON books.category = categories.id 
		WHERE
			isbn LIKE '%$q%' OR
			title LIKE '%$q%' OR
			authors LIKE '%$q%' OR
			publisher LIKE '%$q%' OR
			label LIKE '%$q%' OR
			abstract LIKE '%$q%' ";

$result = mysql_query($query)
	or die("Invalid database query.  Please notify the webmaster.");

$result_count = 0;
$table_headers_sent = 0;

while($r = mysql_fetch_array($result))
{
	extract($r, EXTR_PREFIX_ALL, "r");

	if(strlen($r_abstract) > 255)
	{
		$r_abstract = substr($r_abstract, 0, 255) . "...";
	}

	if($table_headers_sent == 0)
	{
		echo "
			<OL>
		";
		$table_headers_sent = 1;
	}

	$r_abstract =  preg_replace('!('.$q.')!i', 
		'<font color=#CC4444>$1</font>', 
		"$r_abstract"); 
	$r_old_isbn = $r_isbn;
	$r_isbn = preg_replace('!('.$q.')!i', 
		'<font color=#CC4444>$1</font>', 
		"$r_old_isbn"); 
	$r_title = preg_replace('!('.$q.')!i',
                '<font color=#CC4444>$1</font>',
                "$r_title");
	$r_authors = preg_replace('!('.$q.')!i',
                '<font color=#CC4444>$1</font>',
                "$r_authors");
	$r_label = preg_replace('!('.$q.')!i',
                '<font color=#CC4444>$1</font>',
                "$r_label");
	
	
	echo "
				<li><strong>
				<a href=bookview.php?isbn=$r_old_isbn>
					$r_title
				</a>
				</strong><br> 
				by $r_authors<br>
				<blockquote>
				<em>$r_abstract</em>
				<br>
				<em>
				<font size=-1 color=#AAAAAA>
				ISBN: </font>
				<font size=-1 color=#00AA00>
				$r_isbn &nbsp;&nbsp;&nbsp;&nbsp;</font>
			 	<font size=-1 color=#AAAAAA>	
				Category: </font>
				<font size=-1 color=#00AA00>
				$r_label</font>
				</em>
				</font>
				</blockquote>
		";

	$result_count = $result_count + 1;
}

if($table_headers_sent == 1)
{
	echo "
			</OL>
		";
}

if($result_count == 0)
{
	echo "No books matched your search request.";
}

//============================ End Results =================================//

// Now the page footer template.
include('footer.php');

?>
