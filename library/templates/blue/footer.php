<?php

echo "<br clear=both><hr size=1 color=#aaaacc>";

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

echo " ] <br clear=both></center>";


echo "<P>";
echo "<address><center><font size=-1>";
echo "Copyright &copy; 2003 by <a href=mailto:imnes@go.com>Nicholas
      Smith</a> and <a href=http://www.pcolalug.org>The Pensacola
      Linux Users Group</a>.<br>All Rights are Reserved. ";
echo "&nbsp;&nbsp;&nbsp;
	Graphics provided by 
	<a href=http://www.webpagedesign.com.au/ target=_blank>Art
	for the Web</a>.<br>";
echo "</font></center></address>";
echo "</body>";
echo "</html>";
?>

	</td>
  </tr>
</table>
</body>
</html>
