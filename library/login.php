<?php
/*****************************************************************************
 *
 *	login.php
 *	by Nicholas Smith imnes@go.com
 *	Written 3/3/2003
 *
 *	Copyright (C) Nicholas Smith & The Pensacola Linux Users Group
 *
 *---------------------------------------------------------------------------
 *
 *	Display a login form to the user.  If someone is already logged
 *	in, abandon their session.  If no return_url was specified, make
 *	a default to index.php.
 *
 ****************************************************************************/

// Lose their old session if they were logged in.
session_start();
session_destroy();
require_once("include.php");

// Find out if we have a return_url, if not make the default index.php
$return_url = $_GET['return_url'];
if($return_url == '')  
{
	$return_url = 'index.php';
}

// Include the top page template.
$page_title='Login';
include('header.php');

// Display the login form.
echo "<!---- Login Form ----> 
      <form method=post action=login-2.php?return_url=$return_url>      
      <center>
      <table border=0 cellpadding=3 cellspacing=0 bgcolor=#eeeef0>
      <tr><th colspan=2 align=center bgcolor=#7777ff>
      <font color=#ffffff>Please Login</font>
      <tr><th colspan=2>&nbsp;
      <tr>
         <th align=right>Username or Email Address:
         <td><input type=text name=login_name size=30 maxlength=255>
      <tr>
 	 <th align=right>Password:
 	 <td><input type=password name=password size=30 maxlength=255>
      <tr>
         <th colspan=2>&nbsp;
      <tr>
	 <td colspan=2 align=center valign=middle>
         <input type=submit name=login value=Login>
      <tr>
         <th colspan=2>&nbsp;
      <tr>
         <td colspan=2 align=left>
           If you are not currently a library member, please 
           <a href=signup.php?return_url=$return_url>sign-up</a>.<br>
           If you have forgotten your password, please 
           <a href=forgotpassword.php>click here</a>. 
      </table>
      </cener>
      </form>";
// Now the page footer template.
include('footer.php');
?>
