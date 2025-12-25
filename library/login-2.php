<?php
/*****************************************************************************
 *
 *      login-2.php
 *      by Nicholas Smith imnes@go.com
 *      Written 3/3/2003
 *
 *      Copyright (C) Nicholas Smith & The Pensacola Linux Users Group
 *
 *---------------------------------------------------------------------------
 *
 *	Process the login request.
 *
 *	Incoming Variables:
 *
 *		FORM: login_name, password
 *
 *		GET: return_url
 *
 ****************************************************************************/

require_once("include.php");
session_start();

//----------------------------------------------------------------------------
//
// 	Make sure the variables we were waiting for came in.
//
//----------------------------------------------------------------------------
$login_name=addslashes($_POST['login_name']);
$login_password=$_POST['password']; 
$return_url=$_GET['return_url'];
$login_error=0;

if($login_name=="")
{
	echo "<font color=#ff0000>You must specify your username or 
	      email address.</font><br>";
	$login_error=1;
}

if($login_password=="")
{
	echo "<font color=#ff0000>You must enter your password.
              </font><br>";
	$login_error=1;
}
$login_password = md5($login_password);

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
$query = "SELECT * FROM users WHERE password = '$login_password' AND
          ( nick_name = '$login_name' OR email = '$login_name' ) ";

$result = mysql_query($query) 
   or die("Invalid database query.  Please notify the webmaster.");

extract(mysql_fetch_assoc($result), EXTR_PREFIX_ALL, "r");

if($r_id == "") 
{
	// 
 	// 	Invalid Login
	//
	die("Invalid username, email, or password.");
}

//
// Register session variables 
//
$_SESSION["nick_name"] = $r_nick_name;
$_SESSION["first_name"] = $r_first_name;
$_SESSION["last_name"] = $r_last_name;
$_SESSION["email"] = $r_email;
$_SESSION["admin_access"] = $r_admin_access;
$_SESSION["user_id"] = $r_id;
$_SESSION["validated"] = 1;
$_SESSION["theme"] = $r_theme;


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
