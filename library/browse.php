<?php
/*****************************************************************************
 *
 *	browse.php
 *	by Nicholas Smith imnes@go.com
 *	Written 3/3/2003
 *
 *	Copyright (C) Nicholas Smith & The Pensacola Linux Users Group
 *
 *---------------------------------------------------------------------------
 *
 *	Browse the books collection.  Right now this will just dump a
 *	big list of all the books in the database.  This should be given
 *	sorting, paging, and other helpful navigation tools if our list
 *	gets big.
 *
 ****************************************************************************/

// Lose their old session if they were logged in.
session_start();
require_once("include.php");


// Include the top page template.
$page_title='Browse the Collection';
include('header.php');

// Show the books.
echo "<blockquote>";
show_collection();
echo "</blockquote>";

// Now the page footer template.
include('footer.php');



//===========================================================================
//
//	Show the collection of books.
//
//===========================================================================
function show_collection()
{
	// We need a local copy of the database setup variables.
	include("include.php");


	// Setup the database connection.
	$link = mysql_connect($db_host, $db_user, $db_pass)
		or die("Could not connect to the database.
		        Please try again later.");

	mysql_select_db($db_name)
		or die("Could not select the database.
		        Please try again later.");

	// Build  Query
	$query = "SELECT label, title, authors, isbn FROM 
		  categories LEFT JOIN books ON 
		  categories.id = books.category 
		  ORDER BY label, title "; 	

	$result = mysql_query($query)
		or die("Invalid database query.  Please notify the webmaster.");

	
	// Show the results
	$in_list = 0;
	$old_label = "";
	while($r = mysql_fetch_array($result))
	{
		extract($r, EXTR_PREFIX_ALL, "r");
		if($r_label == $old_label)
		{
			if($r_title != "") 
			{
			   if($in_list == 0)
			   {
				echo "<ol>";
				$in_list = 1;
			   }
			   echo "<li> 
                              <a href=bookview.php?isbn=$r_isbn>
				<em>$r_title by $r_authors</em>
			      </a>
			   ";
			}
		}
		else
		{
			if($in_list == 1)
			{
				echo "</ol>";
				$in_list = 0;
				echo "<strong>$r_label</strong>";
			}
			else
			{	
				echo "<br><strong>$r_label</strong>";
			}
			if($r_title != "")
			{
				if($in_list == 0)
				{
					echo "<ol>";
					$in_list = 1;
				}
				echo "<li>
				   <a href=bookview.php?isbn=$r_isbn>
					<em>$r_title by $r_authors</em>
				   </a>
				";
			}
		}

		$old_label = $r_label;
	}

}

?>
