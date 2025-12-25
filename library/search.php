<?php
/*****************************************************************************
 *
 *	search.php
 *	by Nicholas Smith imnes@go.com
 *	Written 3/3/2003
 *
 *	Copyright (C) Nicholas Smith & The Pensacola Linux Users Group
 *
 *---------------------------------------------------------------------------
 *
 *	Display a search form.
 *
 ****************************************************************************/

// Lose their old session if they were logged in.
session_start();
require_once("include.php");

// Include the top page template.
$page_title='Search the Library';
include('header.php');

// Display the Search  form.
echo "<!---- Search Form ----> 
      <form method=get action=search-2.php>      
      <center>
      <table border=0 cellpadding=3 cellspacing=0 bgcolor=#eeeef0>
      <tr><th align=center bgcolor=#7777ff>
      <font color=#ffffff>Search the Library</font>
      <tr><th>&nbsp;
      <tr>
         <th align=left valign=top>Enter part of a title, isbn, or authors name:<br>
         <input type=text name=q size=50 maxlength=255>
      <tr>
         <th>&nbsp;
      <tr>
	 <td align=center><input type=submit value=Search>
	<br><br>
      </table>
      </cener>
      </form>";
// Now the page footer template.
include('footer.php');
?>
