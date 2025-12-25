<?php
/*****************************************************************************
 *
 *      logout.php
 *      by Nicholas Smith imnes@go.com
 *      Written 3/3/2003
 *
 *      Copyright (C) Nicholas Smith & The Pensacola Linux Users Group
 *
 *---------------------------------------------------------------------------
 *
 *	Destroy the users session.  Take them to a page that shows them
 *      as being logged out.
 *
 ****************************************************************************/

// Lose their old session if they were logged in.
session_start();
session_destroy();

header("Location: http://".$_SERVER['HTTP_HOST']
                      .dirname($_SERVER['PHP_SELF'])
                      ."/"."logout-2.php");
?>
