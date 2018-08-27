create table blog_users(
	id int not null auto_increment,
	username varchar(64) not null default '',
	password varchar(128) not null default '',
	nickname varchar(64) not null default '',
	intro text default null,
	avatar varchar(255) not null default '',
	primary key(id)
)ENGINE innodb CHARSET utf8;


create table blog_categories (
	id int not null auto_increment,
	name varchar(64) not null default '',
	created_time int not null default 0,
	user_id int not null default 0,
	primary key(id),
	index(user_id)
)ENGINE innodb CHARSET utf8;


create table blog_tags(
	id int not null auto_increment,
	name varchar(64) not null default '',
	created_time int not null default 0,
	user_id int not null default 0,
	primary key (id),
	index(user_id)
)ENGINE innodb CHARSET utf8;


create table blog_articles(
	id int not null auto_increment,
	title varchar(128) not null default '',
	body text default null,
	created_time int not null default 0,
	uodated_time int not null default 0,
	category_id  int not null default 0,
	user_id int not null default 0,
	primary key(id),
	index(category_id),
	index(user_id)
)ENGINE innodb CHARSET utf8;

create table blog_article_tag_map(
	id int not null auto_increment,
	article_id int not null default 0,
	tag_id int not null default 0,
	primary key(id)
)ENGINE innodb CHARSET utf8;


create table city(
	id int not null auto_increment,
	city varchar(128) not null default'',
	provinceId varchar(32) not null,
	primary key(id)	
)ENGINE innodb CHARSET utf8;

create table province(
	id int not null auto_increment,
	province varchar(128) not null,
	primary key(id)	
)ENGINE innodb CHARSET utf8;


create table user (
	id int not null auto_increment,
	password varchar(32) not null default '',
	email  varchar(128) not null default '',
	primary key(id)
)ENGINE innodb CHARSET utf8;

create table board(
	id int not null auto_increment,
	word_id int not null default 0,
	title varchar(128) not null default'',
	content text default null,
	push_time int not null default 0,
	status tinyint(1) default [(0,'未审核'),(1,'审核')],
	primary key(id),
	index(word_id)
)ENGINE innodb CHARSET utf8;
