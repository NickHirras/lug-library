VARIABLES:

	I like to name my variables descriptively.  Not using
	hungarian notation (if you don't know what that is, good.)
	An underscore seperates multiple words, and everything
	is lowercase.

		Correct:
			$my_name = "Bob";
			$logged_in = 1;

		Incorrect:
			$MyFirstName = "bob";
			$loggedIn = 0;
			$iLogged = 1;

FILES / SCRIPTS:

	When a script has several steps I like to split them into
	seperate files instead of calling the same script 
	repeatedly and branching inside.  Makes debugging a lot
	easier.  When naming scripts name the first one whatever
	you like, then add a -# to the others, like this

		login.php
		login-2.php
		login-3.php

COMMENTS:

	Check existing scripts for an example of the comments to
	include at the top of each script.  Basically describing
	the name of the file, what the script does, who wrote it,
	and when.

	Comment everything in your script.  Seperate main chunks
	of code like this:

		//-----------------------------------
		//	
		//	Get info from database.
		//
		//-----------------------------------

			code goes here;

		//-----------------------------------
		//
		//	validate incoming vars
		//
		//-----------------------------------

			more code here;

	For commenting within code segments where you don't 
	need to seperate it like above, use this style of
	comment.
	
		//
		// 	Smaller Comment
		//
		
			Code Here;

