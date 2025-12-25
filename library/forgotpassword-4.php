<?php
/*****************************************************************************
 *
 *      forgotpassword-4.php
 *      by Nicholas Smith imnes@go.com
 *      Written 3/3/2003
 *
 *      Copyright (C) Nicholas Smith & The Pensacola Linux Users Group
 *
 *---------------------------------------------------------------------------
 *
 *	Put the new password in the database.
 *
 ****************************************************************************/

require_once("include.php");

//
//  Validate data
//
$user_id = $_POST["user_id"];
$old_password = $_POST["old_password"];
$new_password = $_POST["new_password"];
$new_password_confirm = $_POST["new_password_confirm"];

if( $new_password != $new_password_confirm )
{
   die("<font color=#ff0000>Your passwords do not match.</font><br>
        Please <a href=javascript:history.back()>go back</a> and try again.");
}

$password = md5($new_password);

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
$query = "UPDATE users SET password = '$password' WHERE (
          id = $user_id AND password = '$old_password' ) ";
$result = mysql_query($query)
   or die("Invalid database query.  Please notify the webmaster.");

extract(mysql_fetch_assoc($result), EXTR_PREFIX_ALL, "r");

echo "Your password has been changed.  Please <a href=login.php>Login</a>.";

?>
