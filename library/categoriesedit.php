<?php
/*****************************************************************************
 *
 *	categoriesedit.php
 *	by Nicholas Smith imnes@go.com
 *	Written 3/3/2003
 *
 *	Copyright (C) Nicholas Smith & The Pensacola Linux Users Group
 *
 *---------------------------------------------------------------------------
 *
 *	Allow a logged-in user to edit / add / remove categories to
 *	the library.
 *
 ****************************************************************************/

// Lose their old session if they were logged in.
session_start();
require_once("include.php");

// Are we logged-in?
if($_SESSION["validated"] != 1)
{
	die("You must be logged-in to view this page.");
}

// Find out if we have a return_url, default to index.php 
$return_url = $_GET['return_url'];
if($return_url == '')  
{
	$return_url = "index.php"; 
}

// Include the top page template.
$page_title='Edit Categories';
include('header.php');

// Add New Categories Form
add_new_cat_form("$return_url");
echo "<hr size=1 width=30%>";

if($_SESSION["admin_access"] == 1)
{
// Rename Category Form
rename_cat_form("$return_url");
echo "<hr size=1 width=30%>";

// Delete Categories Form
del_cat_form("$return_url");
}

// Now the page footer template.
include('footer.php');


//===========================================================================
//
//	Add a New Category Form
//
//===========================================================================
function add_new_cat_form($return_url)
{
	echo "
		<center> 
		<form method=post action=categoryadd.php?return_url=$return_url>
		
		<table bgcolor=#eeeef0 border=0 cellpadding=2 cellspacing=0>
		<tr>
			<th align=center bgcolor=#7777ff>
			<font color=#ffffff>Add a New Category</font>

		<tr>
			<th>&nbsp;

		<tr>
			<th align=left>Subcategory Of:

		<tr>
			<td><select name=mcat>
		";


	//-------------------- Database Results ------------------------//

	include ("include.php");

	$link = mysql_connect($db_host, $db_user, $db_pass)
		or die("Could not connect to the database.
			Please try again later.");

	mysql_select_db($db_name)
		or die("Could not select the database.
			Please try again later.");

	$query = "SELECT label FROM categories ORDER BY label ";

	$result = mysql_query($query)
		or die("Invalid database query.
			Please notify the webmaster.");

	echo "
			<option value=''>New Master Category</option>";
	
	while($r = mysql_fetch_array($result)) 
	{
		extract($r, EXTR_PREFIX_ALL, "r");

		echo "
				<option value='$r_label'>$r_label</option>";	
	}


	mysql_free_result($result);
	mysql_close($link);

	//-------------- End of Database Results ----------------------------//

	echo "
			</select>
		
		<tr>
			<th align=left>Name of New Category:

		<tr>
			<td><input type=text name=cat_name>

		<tr>
			<td>&nbsp;
	
		<tr>
			<td align=center>
			<input type=submit name=Add value='Add Category'>
			<br><br>
		</table>

		</form>
		</center>
	";
		
}




//===========================================================================
//
//      Rename a Category Form
//
//===========================================================================
function rename_cat_form($return_url)
{
        echo "
                <center>
                <form method=post name=rename action=categoryren.php?return_url=$return_url>

                <table bgcolor=#eeeef0 border=0 cellpadding=2 cellspacing=0>
                <tr>
                        <th align=center bgcolor=#7777ff>
                        <font color=#ffffff>Rename a Category</font>

                <tr>
                        <td>&nbsp;

                <tr>
                        <th align=left>Choose a Category to Rename:

                <tr>
                        <td><select name=cat onClick='javascript:document.rename.new_name.value=this.options[this.selectedIndex].text'>
                ";


        //-------------------- Database Results ------------------------//

        include ("include.php");

        $link = mysql_connect($db_host, $db_user, $db_pass)
                or die("Could not connect to the database.
                        Please try again later.");

        mysql_select_db($db_name)
                or die("Could not select the database.
                        Please try again later.");

        $query = "SELECT id, label FROM categories ORDER BY label ";

        $result = mysql_query($query)
                or die("Invalid database query.
                        Please notify the webmaster.");

	echo "
				<option value='0'>Please Choose One...</option>
		";

        while($r = mysql_fetch_array($result))
        {
                extract($r, EXTR_PREFIX_ALL, "r");

                echo "
                                <option value='$r_id'>$r_label</option>";
        }


        mysql_free_result($result);
        mysql_close($link);


        //-------------- End of Database Results ----------------------------//

        echo "
                        </select>

		<tr>
			<th align=left>New Name:

		<tr>
			<td><input type=text name=new_name>

                <tr>
                        <td>&nbsp;

                <tr>
                        <td align=center>
                        <input type=submit name=Rename value='Rename Category'>
			<br><br>
                </table>

                </form>
                </center>
        ";

}





//===========================================================================
//
//     Delete a Category Form 
//
//===========================================================================
function del_cat_form($return_url)
{
        echo "
                <center>
                <form method=post action=categorydel.php?return_url=$return_url>

                <table bgcolor=#eeeef0 border=0 cellpadding=2 cellspacing=0>
                <tr>
                        <th align=center bgcolor=#7777ff>
                        <font color=#ffffff>Delete a Category</font>

                <tr>
                        <td>&nbsp;

                <tr>
                        <th align=left>Choose a Category to Delete:

                <tr>
                        <td><select name=cat>
                ";


        //-------------------- Database Results ------------------------//


        include ("include.php");

        $link = mysql_connect($db_host, $db_user, $db_pass)
                or die("Could not connect to the database.
                        Please try again later.");

        mysql_select_db($db_name)
                or die("Could not select the database.
                        Please try again later.");

        $query = "SELECT label FROM categories ORDER BY label ";

        $result = mysql_query($query)
                or die("Invalid database query.
                        Please notify the webmaster.");

        echo "
                                <option value=''>Please Choose One...</option>
                ";

        while($r = mysql_fetch_array($result))
        {
                extract($r, EXTR_PREFIX_ALL, "r");

                echo "
                                <option value='$r_label'>$r_label</option>";
        }


        mysql_free_result($result);
        mysql_close($link);

        //-------------- End of Database Results ----------------------------//

        echo "
                        </select>


		<tr>
			<th align=left>Also Delete Sub-Categories:
			<input type=checkbox name=delsubs value=1>
                <tr>
                        <td>&nbsp;

                <tr>
                        <td align=center>
                        <input type=submit name=Delete value='Delete Category'>
                        <br><br>
                </table>

                </form>
                </center>
        ";

}
?>
