If you need access to session variables on your page, and most do, you
should call the function 

	session_start();

at the top of your page.  We use standard PHP4 sessions.  To access a 
session variable you would do something like

	echo $_SESSION["varname"];

Here's a list of the session variables we have defined

	Variable Name		Description
	=============		===========
	nick_name		This is the nickname / username of
				the user.  

	first_name		User's first name
	last_name		User's last name
				These two are optional, users do no
				have to supply their real name to use
				this site.

	email			User's email address.  Expect this
				to be valid.

	admin_access		Set to 1 if this user has been
				granted administrative privileges.

	user_id			The ID # of this user, corresponds to
				the autonumber field in the
				users table of the database.

	theme			The directory name of the template
				we wish to use.  If this isn't set,
				default to 'original'.

	validated		Set to 1 if the user is logged-in.


None of these will be set to valid data if a user hasn't logged in so you
should first check to see that a user has been validated before using
them.  Here's an example of displaying a user's email address.

	if($_SESSION["validated"] == 1)
	{
		echo "Your email address is set to " . $_SESSION["email"];
	}


