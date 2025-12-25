<?php
/*****************************************************************************
 *
 *      categoryren.php
 *      by Nicholas Smith imnes@go.com
 *      Written 3/3/2003
 *
 *      Copyright (C) Nicholas Smith & The Pensacola Linux Users Group
 *
 *---------------------------------------------------------------------------
 *
 *	Rename a category.
 *
 ****************************************************************************/

require_once("include.php");
session_start();

//----------------------------------------------------------------------------
//
// 	Make sure the variables we were waiting for came in.
//
//----------------------------------------------------------------------------
$cat = $_POST["cat"];
$new_name = strtoupper($_POST["new_name"]);
$return_url=$_GET['return_url'];
$login_error=0;


if($cat == "")
{
	echo "<font color=#ff0000>You must choose a category to rename.</font><br>";
	$login_error=1;
}

if($new_name == "")
{
	echo "<font color=#ff0000>You must specify a new name.</font><br>";
	$login_error=1;
}

if($return_url=="")
{
	echo "<font color=#ff0000>Error, no return_url specified.  Please
	      visit the <a href=login.php>Login Page</a>.</font><br>";  
	$login_error=1;
}

if($login_error==1)
{
	echo "Please <a href=javascript:history.back()>go back</a> and try 
              again.";
	exit();
}


//---------------------------------------------------------------------------
//
//	Get the user ID from the database.  Return an error if it's 
//	not found.
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
$query = "UPDATE categories SET label = '$new_name' WHERE id = $cat";

$result = mysql_query($query) 
   or die("Invalid database query.  Please notify the webmaster.");



//
// Free up DB resources.
//
mysql_free_result($result);
mysql_close($link);


//
// We're logged in so lets go to the page we wanted.
//
header("Location: http://".$_SERVER['HTTP_HOST']
                      .dirname($_SERVER['PHP_SELF'])
                      ."/".$return_url);

?>
