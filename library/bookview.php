<?php
/*****************************************************************************
 *
 *      bookview.php
 *      by Nicholas Smith imnes@go.com
 *      Written 3/3/2003
 *
 *      Copyright (C) Nicholas Smith & The Pensacola Linux Users Group
 *
 *---------------------------------------------------------------------------
 *
 *	Show a book, lookup by ISBN.
 *
 *	Incoming Variables:
 *
 *		GET: isbn
 *
 ****************************************************************************/

require_once("include.php");
session_start();

//----------------------------------------------------------------------------
//
// 	Make sure the variables we were waiting for came in.
//
//----------------------------------------------------------------------------
$isbn = $_GET["isbn"];
if($isbn == "")
{
	die("Invalid ISBN.");
}

//---------------------------------------------------------------------------
//
//	Retrieve the record from the database.
//
//---------------------------------------------------------------------------

// 
//  Connect to the database.
//
$link = mysql_connect($db_host, $db_user, $db_pass)
   or die("Could not connect to the database.  Please try again later.");
mysql_select_db($db_name) 
   or die("Could not select the database.  Please try again later.");

//
//  Perform query
//
$query = "SELECT books.id as id, categories.label as label,
		books.isbn as isbn, books.authors as authors,
		books.publisher as publisher, books.copyright
		as copyright, books.page_count as page_count, 
		books.abstract as abstract, books.title as title
		FROM books INNER JOIN categories 
		ON books.category = categories.id WHERE isbn = '$isbn' ";

$result = mysql_query($query) 
   or die("Invalid database query.  Please notify the webmaster.");

extract(mysql_fetch_assoc($result), EXTR_PREFIX_ALL, "r");

$page_title = "Book Details for $r_title";
include("header.php");
if($r_id == "") 
{
	echo "That ISBN doesn't exist in our library.
	     You can try 
		<a href=http://www.booksamillion.com/ncom/books?pid=$isbn
			target=_blank>
		Books-A-Million</a>.
	";

}
else
{
	$book_id = $r_id;

	// Open blockquote for this page content.
	//echo "<blockquote>";

	// Link to the image
	$imgsrc="http://www.booksamillion.com/bam/covers/" 
	   . substr($isbn, 0, 1) 
 	   . "/"
	   . substr($isbn, 1, 2)
	   . "/"
	   . substr($isbn, 3, 3)
	   . "/"
	   . substr($isbn, 6, 3)
	   . "/"
	   . $isbn . ".jpg";
	echo "<a href=http://www.booksamillion.com/ncom/books?pid=$isbn
			target=_blank>
		<img align=left src=$imgsrc border=1 hspace=8 vspace=8
		color=#000000 alt='Buy it at Books-A-Million' width=256>
	</a>";

	// Information from our database, formatted nicely of course.
	$r_abstract = nl2br($r_abstract);
	echo "<H3>$r_title</H3>";
	echo "	<em>Category:</em> $r_label<br>
		<em>ISBN:</em> $r_isbn<br>
		<em>Author(s):</em> $r_authors<br>
		<em>Publisher:</em> $r_publisher<br>
		<em>Copyright:</em> $r_copyright<br>
		<em>Pages:</em> $r_page_count<br>
		<em>Abstract:</em> $r_abstract<br>
		";

//
//	Show the Holdings
//
	// 
	// Display a header for this section of the page.
	//
	echo "<P><center><strong>Holdings:</strong></center>";
	echo "<table align=center border=1  cellpadding=2 cellspacing=0>";
	echo "<tr><th>Owner<th>Availability";

	// Pull in holdings from the database.
	$query = "SELECT users.nick_name as nick_name, 
			ownership.id as book_id, 
			ownership.loaned_to as loaned_to,
			DATE_FORMAT(ownership.due_date, '%M %D, %Y') as due_date
			FROM ownership INNER JOIN users ON ownership.owner = 
			users.id WHERE ownership.isbn = '$isbn'";
	$result = mysql_query($query);
	$result_count=0;

	while ($r = mysql_fetch_array($result))
	{
		extract($r, EXTR_PREFIX_ALL, "r");

		if($r_loaned_to != 0)
		{
			$status = "On-Loan, due back $r_due_date";
		}
		else
		{
		 $status = "Now Available [ <a href=request.php?b_id=$r_book_id>
			  Request This Book</a> ] ";
		}
		echo "<tr><td align=center>$r_nick_name
		      <td align=center>$status ";

		$result_count = $result_count + 1;

	} // End of While
	
	if($result_count == 0)
	{
		echo "<tr><td colspan=2 align=center>Nobody owns this book.";
	}

	echo "</table>
		<center><font size=-1>
		(Due dates are approximate.  We usually borrow and return
		books at our monthly meetings.)
		</font></center>";


//
// Show the reviews.
//
	//
	// Display a header for this section of the page.
        //
	echo "<br clear=all>";
        echo "<P>";

        echo "<font face=verdana size=+0><strong>Member Reviews:</strong></font>
	<hr size=1><P>";

	//
	// Query the database
	//	
	$query = "select users.nick_name as nick_name, users.id as user_id,
		recommended, stars, reviews.id as id,  
		review, DATE_FORMAT(posted, '%M %D, %Y') as posted 
		from reviews inner join users on reviews.user_id = users.id 
		where isbn='$isbn' ";

	$result = mysql_query($query);
	$result_count=0;
	$i_wrote_review=0;
	
	//
	// Show the results.
	//	
	while($r = mysql_fetch_array($result)) 
	{
		extract ($r, EXTR_PREFIX_ALL, "r");
		$result_count = $result_count + 1;

		if(($r_user_id == $_SESSION['user_id']) && 
		   ($_SESSION['validated']==1) )
		{
			$i_wrote_review = 1;
		}

		$r_review = nl2br($r_review);
		echo "<blockquote>";

		echo "On $r_posted 
			<strong>$r_nick_name</strong> rated this book ";

		if($r_stars > 5)
		{
			$r_stars = 5;
		}
		$blank_stars = 5 - $r_stars;

		for($i=0; $i<$r_stars; $i++)
		{
			echo "<img src=star_on.gif alt=*>";
		}
		for($i=0; $i<$blank_stars; $i++)
		{
			echo "<img src=star_off.gif alt=O>";
		}	

		echo "<br>";
                if($r_recommended == 1)
                {
                        echo "I would recommend this book. ";
                }
                else
                {
                        echo "I would not recommend this book. ";
                }

		if( (($r_user_id == $_SESSION['user_id']) && 
		    ($_SESSION['validated']==1) ) || 
		    ($_SESSION['admin_access']==1) )
		{
			echo "&nbsp;&nbsp;&nbsp;&nbsp;
			[ <a href=reviewchange.php?r=$r_id&return_url=bookview.php?isbn=$isbn>Edit</a> |
			  <a href=reviewdelete.php?r=$r_id&return_url=bookview.php?isbn=$isbn>Remove</a> ]"; 
			
		}
		echo "<br><blockquote>";

                echo "<em>$r_review</em><br>";

		echo "</blockquote><br></blockquote>";
	}

	echo "<center>";
	if($_SESSION['validated'] == 1)
	{
	if($result_count == 0)
	{
		echo "Be the first member to 
			<a href=review.php?isbn=$isbn&return_url=bookview.php?isbn=$isbn>
			write a review</a> for this book.";
	}
	else
	{
		if($i_wrote_review == 0)
		{
			echo " 
				<a href=review.php?isbn=$isbn&return_url=bookview.php?isbn=$isbn>
				Write your own review for this book</a>.";
		}
	}
	}
	else	
	{
		echo "<center>
			You must 
		<a href=login.php?return_url=bookview.php?isbn=$isbn>log-in</a>
		to review this book.</center>";
	}
	echo "</center>";

	// 
	// All done, close the blockquote
	//
	//echo "</blockquote>";	
}
include("footer.php");



//
// Free up DB resources.
//
mysql_free_result($result);
mysql_close($link);



?>
