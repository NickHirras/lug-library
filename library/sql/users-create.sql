-------------------------------------------------------------------------------
--
--	users-create.sql
--	created by Nicholas Smith (imnes@go.com)
--	written 3/3/2003
--
-------------------------------------------------------------------------------

--
--	Setup the users table and insert an administrative account.
--	The default administrative account is username/pass: admin
--	You should login and change this once the library is
--	installed.
--
use pluglib;

drop table if exists users;

create table users  
(
	id		int unsigned not null auto_increment primary key,
	email		char(128) not null,
	password	char(255) not null,
	first_name	char(50),
	last_name	char(50),
	nick_name	char(50),
	created_when	timestamp,
	created_ip	char(20),
        theme           char(128),
	admin_access	tinyint not null
);

insert into users (email, password, nick_name, created_ip, admin_access) values
('admin', '21232f297a57a5a743894a0e4a801fc3',
 'Administrator', '127.0.0.1', 1);

