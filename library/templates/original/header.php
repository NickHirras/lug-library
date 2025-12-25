<?php

echo "<html>
<head>
<META HTTP-EQUIV='expires' VALUE='Thu, 16 Mar 2000 11:00:00 GMT'>
<META HTTP-EQUIV='pragma' CONTENT='no-cache'>
<META HTTP-EQUIV='Cache-Control' VALUE='no-cache, must-revalidate'>
<title>
   PCOLALUG Library - $page_title
</title>

<body bgcolor=#ffffff text=#000000> 

<a href=http://www.pcolalug.org><img src=templates/original/lugheader.gif border=0 alt='PcolaLUG Homepage'></a>  

<H3> $page_title </H3>";

// Navbar Links
echo "<center>";
echo "[
<a href=index.php>Home</a> | 
<a href=browse.php>Browse the Books</a> | 
<a href=search.php>Search for a Book</a> | ";

if(isset($_SESSION["validated"]))
if($_SESSION["validated"] == 1)
{
   echo "
   	<a href=manage.php>Manage My Collection</a> | 
	<a href=profile.php>My Profile</a> | 
   ";

   if(isset($_SESSION["admin_access"]))
   if($_SESSION["admin_access"] == 1)
   {
	echo "
		<a href=useradmin.php>Accounts</a> |
	     ";
   }
}
if(isset($_SESSION["validated"]))
{
	if($_SESSION["validated"]==1)
	{
		echo "<a href=logout.php>Logout</a>";
	}
	else
	{
		echo "<a href=login.php>Login</a>";
	}
}
else
{
	echo "<a href=login.php>Login</a>";
}

echo " ] <br clear=both> <hr size=1 color=#aaaacc></center>";
?>
