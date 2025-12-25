<?php
/*****************************************************************************
 *
 *      forgotpassword.php
 *      by Nicholas Smith imnes@go.com
 *      Written 3/3/2003
 *
 *      Copyright (C) Nicholas Smith & The Pensacola Linux Users Group
 *
 *---------------------------------------------------------------------------
 *
 *	If a user forgets his/her password email them a backdoor
 *	login link,  Once they're logged-in they can update their 
 *	password.
 *
 ****************************************************************************/


//
//  Present a form to get the user's email address.
//

$page_title = "Retrieve Your Lost Password";
include("header.php");

echo "
	<center>
	<form method=post action=forgotpassword-2.php>
	<table border=0 cellpadding=2 cellspacing=0 bgcolor=#eeeef0>

	<tr> 
	  <th align=right>Email Address:
	  <td><input type=text name=email size=30 maxlength=255>

	<tr>
	  <th colspan=2>&nbsp;
 
	<tr>
	  <td colspan=2 align=center valign=middle>
	  <input type=submit name=Proceed value=Proceed>

	</table>
	</form>
	</center>
	";

include("footer.php");
