<?php
// Here we go.
?>
<html>
<head>
<title>P'colaLUG Library - <?=$page_title?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">
<!--

if (document.images) {
  image1on = new Image();
  image1on.src = "templates/blue/b1on.jpg";

  image2on = new Image();
  image2on.src = "templates/blue/b2on.jpg";

  image3on = new Image();
  image3on.src = "templates/blue/b3on.jpg";

  image4on = new Image();
  image4on.src = "templates/blue/b4on.jpg";

  image5on = new Image();
  image5on.src = "templates/blue/b5on.jpg";

  image6on = new Image();
  image6on.src = "templates/blue/b6on.jpg";

<?php
 if($_SESSION["validated"] == 1)
 {
  echo ' 
  image7on = new Image();
  image7on.src = "templates/blue/b7outon.jpg";
  ';
 }
 else
 {
  echo '
  image7on = new Image();
  image7on.src = "templates/blue/b7inon.jpg";
  ';
 }
?>

  image1off = new Image();
  image1off.src = "templates/blue/b1.jpg";

  image2off = new Image();
  image2off.src = "templates/blue/b2.jpg";

  image3off = new Image();
  image3off.src = "templates/blue/b3.jpg";

  image4off = new Image();
  image4off.src = "templates/blue/b4.jpg";

  image5off = new Image();
  image5off.src = "templates/blue/b5.jpg";

  image6off = new Image();
  image6off.src = "templates/blue/b6.jpg";

<?php
if($_SESSION["validated"] == 1)
{
  echo '
  image7off = new Image();
  image7off.src = "templates/blue/b7out.jpg";
  ';
}
else
{
  echo '
  image7off = new Image();
  image7off.src = "templates/blue/b7in.jpg";
  ';
}
?>

}

function changeImages() {
  if (document.images) {
    for (var i=0; i<changeImages.arguments.length; i+=2) {
      document[changeImages.arguments[i]].src = eval(changeImages.arguments[i+1] + ".src");
    }
  }
}

// -->
</script>
</head>
<!--#6F7A9E-->
<body bgcolor="#6F7A9E" text="#000044" link="#222277" vlink="#222277" alink="#222277" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<a href="http://www.pcolalug.org"> 
  <img src="templates/blue/lugheader.gif" alt="PCOLALUG Homepage" border="0">
</a>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td colspan="2" background="templates/blue/topbg.jpg"><img src="templates/blue/top.jpg" width="383" height="29"></td>
  </tr>
  <tr valign=top> 
    <td width="11%" background="templates/blue/left.jpg"> 
      <p><img src="templates/blue/lefttop.jpg" width="151" height="59"><br>
        <a href="index.php" onMouseOver="changeImages('image1', 'image1on')" onMouseOut="changeImages('image1', 'image1off')"><img name="image1" src="templates/blue/b1.jpg" width="151" alt='Homepage' height="33" border="0"></A><br>
        <a href="browse.php" onMouseOver="changeImages('image2', 'image2on')" onMouseOut="changeImages('image2', 'image2off')"><img name="image2" src="templates/blue/b2.jpg" width="151" height="33" alt='Browse the Collection' border="0"></A><br>
        <a href="search.php" onMouseOver="changeImages('image3', 'image3on')" onMouseOut="changeImages('image3', 'image3off')"><img name="image3" alt='Search for a Book' src="templates/blue/b3.jpg" width="151" height="33" border="0"></A><br>

<?php
if($_SESSION["validated"] == 1)
{
?>
	<a href="manage.php" onMouseOver="changeImages('image4', 'image4on')" onMouseOut="changeImages('image4', 'image4off')"><img name="image4" src="templates/blue/b4.jpg" alt='Manage Your Books' width="151" height="33" border="0"></A><br>
        <a href="profile.php" onMouseOver="changeImages('image5', 'image5on')" onMouseOut="changeImages('image5', 'image5off')"><img name="image5" src="templates/blue/b5.jpg" alt='Update Your Profile' width="151" height="33" border="0"></A><br>
<?php
}

if($_SESSION["admin_access"] == 1)
{
?>
	<a href="useradmin.php" onMouseOver="changeImages('image6', 'image6on')" onMouseOut="changeImages('image6', 'image6off')"><img name="image6" src="templates/blue/b6.jpg" width="151" height="33" border="0" alt='Manage User Accounts'></A><br>
<?php
}
?>
	<a href="<?php
	if($_SESSION["validated"] == 1)
	{
		echo "logout.php";
	}
	else
	{
		echo "login.php";
	}
	?>" onMouseOver="changeImages('image7', 'image7on')" onMouseOut="changeImages('image7', 'image7off')"><img name="image7" alt='Login or Logout' src="templates/blue/<?php
	if($_SESSION["validated"] == 1)
	{
		echo "b7out.jpg";
	}
	else
	{
		echo "b7in.jpg";
	}
	?>" width="151" height="33" border="0"></A><br>
        <img src="templates/blue/bot.jpg" width="151" height="60"><br>
      </p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp; </p>
    </td>
    <td width="95%" valign="top"> 
