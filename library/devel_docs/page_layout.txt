All the pages on the site wrap themselves with a master header and footer.
They can be modified however you like to attain the look you want, just
make sure to look at the existing header.php file so you will know which
navigational links to include.  You'll notice that some links only appear
if a user is logged in and if a user has administrative access.  Make sure
to keep those checks in your new header files.

*** NOTE ON TEMPLATES:

	The templates have now been abstracted slightly.  Templates are
	stored under /templates/<name_of_this_template>/header.php
			and                             footer.php

	Check out the actual /header.php and /footer.php which simply
	include the templates you want to use.  This makes it easy
 	for the webmaster to switch templates by editing just two
	lines.  Eventually I would like to allow members to choose 
	their own templates and save their preferences in the
	profiles.

	When you add templates make sure to edit the profile.php, 
	and profile-2.php so that users will be able to select
	the new templates.

*** END OF NOTE:

When you're creating a new page for the site, you'll want to include several
files.  One is 'include.php', which contains login information that you
will need if you want to access the database from your page.

If you are going to use the global header/footer on your page, you should
first define the title of the page

	$page_title = "Title of My Page";

Then you can include the header before your content

	include("header.php");

And the footer after your content

	include("footer.php");

That's all you need to get started.
