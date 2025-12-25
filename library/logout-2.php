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
 *	Destroy the users session.
 *
 ****************************************************************************/

// Lose their old session if they were logged in.
session_start();
session_destroy();
require_once("include.php");

$page_title = "Logout";
include("header.php");

echo "You are now logged out.";

include("footer.php");
