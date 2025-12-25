<?php
/*****************************************************************************
 *
 *      categorydel.php
 *      by Nicholas Smith imnes@go.com
 *      Written 3/3/2003
 *
 *      Copyright (C) Nicholas Smith & The Pensacola Linux Users Group
 *
 *---------------------------------------------------------------------------
 *
 *	Delete a category.
 *
 ****************************************************************************/

require_once("include.php");
session_start();

//----------------------------------------------------------------------------
//
// 	Make sure the variables we were waiting for came in.
//
//----------------------------------------------------------------------------
$cat = addslashes($_POST["cat"]);
$delsubs = $_POST["delsubs"];

$return_url=$_GET['return_url'];
$login_error=0;


if($cat == "")
{
	echo "<font color=#ff0000>You must choose a category to delete.</font><br>";
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
if($delsubs == 1)
{
	$query2 = "DELETE FROM categories WHERE label LIKE '$cat -- %'";
}
$query = "DELETE FROM categories WHERE label LIKE '$cat'";

$result = mysql_query($query) 
   or die("Invalid database query.  Please notify the webmaster.");

if($query2 != "")
{
	$result = mysql_query($query2)
		or die("Invalid database query.  Please notifty the webmaster");
}


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
