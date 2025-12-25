-------------------------------------------------------------------------------
--
--      books-create.sql
--      created by Nicholas Smith (imnes@go.com)
--      written 3/3/2003
--
-------------------------------------------------------------------------------

use pluglib;

--
--	Create the heirarchy of categories
--

drop table if exists categories;

create table categories
(
	id		int unsigned not null auto_increment primary key,
	label		char(255)
);


--
--	Create the table to hold the collection of books. 
--

drop table if exists books;

create table books 
(
	id		int unsigned not null auto_increment primary key,
	title		char(128),
	isbn		char(32),
	authors		char(255),
	publisher	char(50),
	copyright	year,
	category	int unsigned not null references categories(id),
	page_count	int unsigned,
	abstract	text,
	unique		(isbn)
);


--
--	Create a table to map owners to books
--

drop table if exists ownership;

create table ownership
(
	id		int unsigned not null auto_increment primary key,
	isbn		char(32),
	owner		int unsigned not null references users(id),
	loaned_to 	int unsigned not null references users(id),
	loaned_on	date,
	due_date	date
);

--
--	Create a table to hold member reviews of this book.
--
 
drop table if exists reviews;

create table reviews
(
	id		int unsigned not null auto_increment primary key,
	user_id		int unsigned not null references users(id),
	isbn		char(32),
	recommended	tinyint,
	stars		tinyint,
	review		text, 
	posted		timestamp
);
 
