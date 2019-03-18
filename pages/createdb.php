<?php
header('Content-Type: text/html; charset=utf-8');
include_once 'functions.php';
connect();

$ct1 = 'create table countries(
  id int not null auto_increment primary key,
  country varchar(100) unique
) default charset="utf8"';

$ct2 = 'create table cities(
  id int not null auto_increment primary key,
  city varchar(100),
  countryid int,
  foreign key(countryid) references countries(id) on delete cascade,
  ucity varchar(200)
) default charset="utf8"';

$ct3 = 'create table hotels(
  id int not null auto_increment primary key,
  hotel varchar(100),
  cityid int,
  foreign key(cityid) references cities(id) on delete cascade,
  countryid int,
  foreign key(countryid) references countries(id) on delete cascade,
  stars int,
  cost int,
  info varchar(1024)) default charset="utf8"';

$ct4 = 'create table images(
  id int not null auto_increment primary key,
  imagepath varchar(255),
  hotelid int,
  foreign key(hotelid) references hotels(id) on delete cascade
) default charset="utf8"';

$ct5 = 'create table roles(
  id int not null auto_increment primary key,
  role varchar(255)) default charset="utf8"';

$ct6 = 'create table users(
  id int not null auto_increment primary key,
  login varchar (255) unique,
  pass varchar(128),
  email varchar(128),
  discont int,
  roleid int,
  foreign key(roleid) references roles(id) on delete cascade,
  avatar varchar(200)
) default charset="utf8"';

mysql_query($ct1);
log_mysql(mysql_errno());
mysql_query($ct2);
log_mysql(mysql_errno());
mysql_query($ct3);
log_mysql(mysql_errno());
mysql_query($ct4);
log_mysql(mysql_errno());
mysql_query($ct5);
log_mysql(mysql_errno());
mysql_query($ct6);
log_mysql(mysql_errno());