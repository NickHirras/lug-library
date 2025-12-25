<?php
/*****************************************************************************
 *
 *      forgotpassword-2.php
 *      by Nicholas Smith imnes@go.com
 *      Written 3/3/2003
 *
 *      Copyright (C) Nicholas Smith & The Pensacola Linux Users Group
 *
 *---------------------------------------------------------------------------
 *
 *	Lookup the user in the database and generate an email to them.
 *
 ****************************************************************************/

require_once("include.php");

//
//  Validate data
//
$email = addslashes($_POST["email"]);
if($email == "")
{
   die("<font color=#ff0000>You must specify a valid email address.  It must
        be the same one you used to register for your account.</font><br>
        Please <a href=javascript:history.back()>go back</a> and try again.");
}

// 
// Connect to the database
//
$link = mysql_connect($db_host, $db_user, $db_pass)
   or die("Could not connect to the database.  Please try again later.");
mysql_select_db($db_name)
   or die("Could not select the database. Please try again later.");


// 
//  Perform Query
//
$query = "SELECT id, password FROM users WHERE email = '$email' ";
$result = mysql_query($query)
   or die("Invalid database query.  Please notify the webmaster.");

extract(mysql_fetch_assoc($result), EXTR_PREFIX_ALL, "r");

if($r_id == "")
{
	die("I could not find a user registered with that email address.");
}

//
//   Send an email.
//
$url = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF'])
                 . "/forgotpassword-3.php?u=".$r_id."&p=".$r_password;
$to = $email;
$subject = "PcolaLUG Library - Lost Password";
$body = "We encrypt all our passwords so we are unable to tell you
what your original password was.  Please follow the link below to
change your password to something new.

<a href=" . $url . ">" . $url . "</a>

AOL users copy this into the address bar of your browser:
$url

";

if(mail($to, $subject, $body))
{
   echo "An email has been sent containing a link for you to change
         your password. It may take several minutes for the message 
         to reach you, especially if our servers are busy.";
}
else
{
   echo "There was an error attempting to send you an email.  Please
         notify the webmaster if you continue to have trouble."; 
}

?>
