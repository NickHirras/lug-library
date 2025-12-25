<?php

//----------------------------------------------
//
//
//----------------------------------------------

$theme = $_SESSION["theme"];
if($_SESSION["theme"] == "")
{
   $theme = "original";
}	

include("templates/$theme/header.php");

?>
