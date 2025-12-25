<?php
/*****************************************************************************
 *
 *	request.php
 *	by Nicholas Smith imnes@go.com
 *	Written 3/3/2003
 *
 *	Copyright (C) Nicholas Smith & The Pensacola Linux Users Group
 *
 *---------------------------------------------------------------------------
 *
 *	Send an email request to the book owner notifying him that we
 *	wish to borrow this book.
 *
 ****************************************************************************/

// Lose their old session if they were logged in.
session_start();
require_once("include.php");

// Get incoming var
$book_id = $_GET["b_id"];


// Make sure we're logged in.
if($_SESSION["validated"] != 1)
{
	die("You must first
		<a href=login.php?return_url=request.php?b_id=$book_id>log-in</a>
		to request a book.");
}

// Make sure a book ID was sent
if($book_id == "")
{
	die("A book ID was expected on the incoming URL but not found.");
}

//------------------------------------------------------
// Get the information for the email from the database.
//------------------------------------------------------
$link = mysql_connect($db_host, $db_user, $db_pass)
	or die("Could not connect to the database.  Please try again later.");
mysql_select_db($db_name)
	or die("Could not select the database.  Please try again later.");

$query = "SELECT title, books.isbn as isbn, authors, email FROM ownership 
		INNER JOIN books ON ownership.isbn = books.isbn 
		INNER JOIN users ON ownership.owner = users.id 
		WHERE ownership.id = $book_id ";

$result = mysql_query($query)
	or die("Invalid database query.  Please notify the webmaster.");

extract (mysql_fetch_assoc($result), EXTR_PREFIX_ALL, "r");

if($r_email == "")
{
	die("I could not locate that book in my database.");
}

 
//-----------------------------------
// Generate and Send an Email
//-----------------------------------
$to = "$r_email";
$subject = "P'ColaLUG Library Book Request";
$body = $_SESSION["nick_name"] . " - (" . $_SESSION["email"] . ")" .
" has requested to borrow a book you own.  The book is $r_title by $r_authors.  ISBN Number $r_isbn.

Please send an email response to the user so he knows you received his request.  Also, when you agree to let someone borrow a book, please visit the library website and mark the book as on-loan so other members know it is not available at this time.
"; 

if(mail($to, $subject, $body))
{
	echo "Your request has been sent.  The owner of this book should
		respond to you by email.  If you have not received a 
		response after several days you may try to request again
		or get in touch with the owner yourself directly.";
}
else
{
	echo "There was a problem emailing your request to the owner. 
		Please try again later.  If the problem persists please
		notify the webmaster.";
}

?>
