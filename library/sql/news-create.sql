-------------------------------------------------------------------------------
--
--	news-create.sql
--	created by Nicholas Smith (imnes@go.com)
--	written 3/3/2003
--
-------------------------------------------------------------------------------

--
--	Setup the news announcements table.  This is content that will
--	be shown on the HOME page.
--
use pluglib;

drop table if exists news;

create table news  
(
	id		int unsigned not null auto_increment primary key,
	posted		timestamp,
	headline	char(128),
	story		text
);

insert into news (headline, story) values
	('We''ve gone live!',  
	 'The site officially went live today.  Have a look around, test things out.  If you encounter any problems notify the webmaster.  Include the URL of the page the problem occurred on as well as what you were doing when it happend.');

