<?php
/*****************************************************************************
 *
 *	manage.php
 *	by Nicholas Smith imnes@go.com
 *	Written 3/5/2003
 *
 *	Copyright (C) Nicholas Smith & The Pensacola Linux Users Group
 *
 *---------------------------------------------------------------------------
 *
 *	Main links page for the management area.  This is where users can
 *	add new books to their collection, edit old entries, and remove
 *	entries.
 *
 ****************************************************************************/

session_start();
require_once("include.php");

// Make sure we're logged-in, required for this page.
if($_SESSION['validated'] != 1)
{
	die("You must <a href=login.php?return_url=manage.php>log-in</a>
             before you can access this page.");
}

// Include the top page template.
$page_title='Manage My Collection';
include('header.php');

// Setup a subset of links.     
echo "<center>
      [ <a href=bookadd.php>Add a New Book</a> ]
      </center><P>
     ";

// Display a list of the books that this person owns.
// For now it won't be navicable, just a full listing.
show_my_books();

// Display a list of the books I have borrowed and not yet returned.
show_my_borrows();



// Include the bottom page template.
include('footer.php');


//==========================================================================
//
//	Display a list of books I have borrowed and not yet returned.
//
//==========================================================================
function show_my_borrows()
{
        include("include.php");

        $link = mysql_connect($db_host, $db_user, $db_pass)
                or die("Could not connect to the database.
                        Please try again later.");

        mysql_select_db($db_name)
                or die("Could not select the database.
                        Please try again later.");

        $user_id = $_SESSION['user_id'];

        $query = "SELECT *, to_days(due_date)-to_days(now()) as days_til_due, 
		DATE_FORMAT(due_date, '%M %D, %Y') as due_date    
		  FROM books INNER JOIN ownership ON books.isbn = ownership.isbn
		  WHERE loaned_to = $user_id
                  ORDER BY due_date DESC ";

        $result = mysql_query($query)
                or die("Invalid database query.  Please notify
                        the webmaster.");

        $num_records=0;
        $alt_colors[0] = "#eeeeee";
        $alt_colors[1] = "#dddddd";
        $alt_color = 0;

        echo "<center>  <P>
			<HR size=1 width=30%>
			<P>
			Books I Have Borrowed and Not Yet Returned
			<P>
                <table bgcolor=#ffffff cellpadding=2 cellspacing=0 width=80%>
                <tr bgcolor = #ffcc33>
                        <th>Title
                        <th>Due&nbsp;Date
                ";

 
        while($r = mysql_fetch_array($result))
        {
                // Get the next record.
                extract($r, EXTR_PREFIX_ALL, "r");
                $num_records = $num_records + 1;

                // Display it.
                echo "
                <tr bgcolor=$alt_colors[$alt_color]>
                <td><a href=bookview.php?isbn=$r_isbn>$r_title</a>
                <td align=center>";
		
		if( $r_days_til_due < 1 )
		{
			echo("<font color=#ff0000>$r_due_date</font>");
		}
		else
		{
			echo "$r_due_date";
		}


                // Rotate the bgcolor of the rows.
                $alt_color = $alt_color + 1;
                if($alt_color > 1)
                {
                        $alt_color = 0;
                }

	}

        echo "</table>
                </center>";

        if($num_records==0)
        {
                echo "<center>You do not have any outstanding books on file.</center>";

        }

}


//===========================================================================
// 
//	Display a list of the books this user owns.
//
//===========================================================================
function show_my_books()
{
	include("include.php");
	
	$link = mysql_connect($db_host, $db_user, $db_pass)
 		or die("Could not connect to the database.  
	   	   	Please try again later.");

	mysql_select_db($db_name)
		or die("Could not select the database.  
			Please try again later.");

	$user_id = $_SESSION['user_id'];

	$query = "SELECT *, ownership.id as owner_id
		  FROM books INNER JOIN ownership ON 
		  ownership.isbn = books.isbn  
		  WHERE owner = $user_id 
		  ORDER BY title ";

	$result = mysql_query($query)
		or die("Invalid database query.  Please notify
			the webmaster.");

	$num_records=0;
	$alt_colors[0] = "#eeeeee";
	$alt_colors[1] = "#dddddd";
	$alt_color = 0;

	echo "<center>
		<table bgcolor=#ffffff cellpadding=2 cellspacing=0 width=80%>
		<tr bgcolor = #ffcc33>
			<th>Title
			<th>Status
			<th>Action
		";

	while($r = mysql_fetch_array($result)) 
	{
		// Get the next record.
		extract($r, EXTR_PREFIX_ALL, "r");
		$num_records = $num_records + 1;

		if($r_loaned_to == 0)
		{
			$status = "<font color=#008800>Available</font>";
		}
		else
		{
			$status = "<font color=#CC0000>On-Loan</font>";  
		}

		// Display it.
		echo "
		<tr bgcolor=$alt_colors[$alt_color]>
		<td><a href=bookview.php?isbn=$r_isbn>$r_title</a> 
		<a href=bookedit.php?isbn=$r_isbn><img
			border=0 src=icon_pencil.gif alt='Edit Book Details'></a>&nbsp;<a 
		href=bookdel.php?o_id=$r_owner_id&confirmed=><img
			border=0 src=icon_trashcan.gif alt='Remove My Copy from the Library'></a>
		<td align=center nowrap>$status
		<td align=center nowrap>";
			
		if($r_loaned_to == 0)
		{
			echo "[&nbsp;<a href=checkout.php?id=$r_owner_id>Check-Out</a>&nbsp;]
			";
		}
		else
		{
                        echo "[&nbsp;<a href=checkin.php?id=$r_owner_id>Check-In</a>&nbsp;]
			";
		}

		// Rotate the bgcolor of the rows.
		$alt_color = $alt_color + 1;
		if($alt_color > 1)
		{
			$alt_color = 0;
		};		
	}

	echo "</table>
		</center>";

	if($num_records==0)
	{
		echo "<center>You do not own any books on file.</center>";

	}
}


?>
