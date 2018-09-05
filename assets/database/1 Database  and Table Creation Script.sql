
-- Create Database:

CREATE DATABASE newsportal;

-- Selecting the News Portal Database:
USE newsportal;


-- Table Structure: tblUser
create table if not exists tblUser
(
  userId int(11) not null auto_increment,
  userName varchar(50) not null unique,
  firstName varchar(50) not null,
  lastName varchar(50) not null,
  email varchar(50) not null unique,
  password varchar(25) not null,
  PRIMARY KEY (userId)
);


-- Table Structure: tblNews
create table if not exists tblNews
(
  newsId int(11) not null auto_increment,
  title varchar(300) not null,
  description text not null,-- TEXT format
  urlToImage varchar(300), -- Error
  publishedAt datetime default NOW(),
  lastUpdated datetime null,-- Will be null at the very start(use trigger)
  typeOfNews varchar(10) default 'public',
  authorId int(11) not null,
  PRIMARY KEY (newsId),
  FOREIGN KEY (authorId) REFERENCES tblUser(userId)
);


-- Table Structure: tblRating
create table if not exists tblRating
(
  userId int(11) not null,
  newsId int(11) not null,
  rating int(2) not null,
  PRIMARY KEY (userId,newsId),-- Candidate Key
  FOREIGN KEY (userId) REFERENCES tblUser(userId),
  FOREIGN KEY (newsId) REFERENCES tblNews(newsId)
);


-- Table Structure: tblTag
create table if not exists tblTag
(
  newsId int(11) not null,
  tag varchar(30) not null,
  FOREIGN KEY (newsId) REFERENCES tblNews(newsId)
);

-- Table Structure: tblComment
create table if not exists tblComment
(
  newsId int(11) not null,
  userId int(11) not null,
  comment text not null,
  FOREIGN KEY (newsId) REFERENCES tblNews(newsId),
  FOREIGN KEY (userId) REFERENCES tblUser(userId)
);



