<?php
/*****************************************************************************
 *
 *      signup.php
 *      by Nicholas Smith imnes@go.com
 *      Written 3/3/2003
 *
 *      Copyright (C) Nicholas Smith & The Pensacola Linux Users Group
 *
 *---------------------------------------------------------------------------
 *
 *	New User Registration Form.  Send entries to signup-2.php
 *
 ****************************************************************************/

//
//  Get session information going, we need it for the navbar if nothing else.
//
session_start();
require_once("include.php");

//
//  Display the global header.
//
$page_title = "New User Registration";
include("header.php");

//
//  Validate the return url.
//
$return_url = $_GET["return_url"];
if($return_url=="")
{
	$return_url = "login.php";
}

//
//  Display the registration form.
//
echo "
	<form method=post action=signup-2.php?return_url=$return_url>
	<center>
	
	<table border=0 cellspacing=0 cellpadding=2 bgcolor=#eeeef0>
	<tr>
	  <th colspan=2 align=center valign=middle bgcolor=#7777ff>
	  <font color=#ffffff>New User Registration</font>
	<tr>
	  <th colspan=2>&nbsp;
	<tr>
	  <th align=right>Email Address: 
	  <td><input type=text name=email size=30 maxlength=255>*
	<tr>
	  <th colspan=2>&nbsp;
	<tr>
	  <th align=right>Password:
	  <td><input type=password name=password size=30 maxlength=255>*
	<tr>
	  <th align=right>Confirm Password:
	  <td><input type=password name=confirm_password size=30 maxlength=255>*
	<tr>
	  <th colspan=2>&nbsp;
	<tr>
	  <th align=right>First Name:
	  <td><input type=text name=first_name size=30 maxlength=255>
	<tr>
	  <th align=right>Last Name:
	  <td><input type=text name=last_name size=30 maxlength=255>
	<tr>
	  <th colspan=2>&nbsp;
	<tr>
	  <th align=right>Username: 
	  <td><input type=text name=nick_name size=30 maxlength=255>
	<tr>
	  <th colspan=2>&nbsp;
	<tr>
	  <th colspan=2 align=center valign=middle>
	  <input type=submit name=Sign-Up value=Sign-Up>
	<tr>
	  <th colspan=2>&nbsp;
 	<tr>
	  <td colspan=2 align=center valign=middle>
		<font size=-1><em>
	    	* = Required<br>
		This site relies extensively on email to function properly,<br>
		please make sure your email address is correct to avoid<br>
		any problems.  
		<a href=help.html#whyemailreq target=_blank>Find out why.</a>
		</em></font>
		
	</table>
	</center>
	</form>
";


//
//  Display the global footer.
//
include("footer.php");

?>
