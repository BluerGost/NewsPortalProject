-- Insert Dummy Data in the table:


-- Insert data into tblUser:
insert into tblUser(userName,firstName,lastName,email,password) values
('kev123','Kevin','Biswas','kev123@gmail.com','kev123'),
('don123','Don','Biswas','don123@gmail.com','don123'),
('rony123','Rony','Biswas','rony123@gmail.com','rony123'),
('vincent123','Vincent','Xavier','vincent123@gmail.com','vincent123'),
('john123','John','Gomoes','john123@gmail.com','john123'),
('rakin123','Rakin','Kamar','rakin123@gmail.com','rakin123'),
('sunny123','Sunny','Luchia','sunny123@gmail.com','sunny123');



-- Table Structure: tblNews
create table if not exists tblNews
(
  newsId int(11) not null auto_increment,
  title varchar(300) not null,
  description text not null,-- TEXT format
  urlToImage varchar(300) null, -- Error
  publishedAt datetime default NOW(),
  lastUpdated datetime null,-- Will be null at the very start(use trigger)
  typeOfNews varchar(10) default 'public',
  authorId int(11) not null,
  PRIMARY KEY (newsId),
  FOREIGN KEY (authorId) REFERENCES tblUser(userId)
);

-- Insert data into tblNews:
insert into tblNews(title,description,urlToImage,typeOfNews,authorId) values
('What is Lorem Ipsum?','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.','https://www.pexels.com/photo/abstract-blur-bubble-clean-268819/','private',1),
('Where does it come from?','Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.
The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.','https://www.pexels.com/photo/scenic-of-ocean-during-sunset-1139541/','PUBLIC',2),
('Why do we use it?','It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using ''Content here, content here'', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for lorem ipsum will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).','https://www.pexels.com/photo/photo-of-man-standing-on-rock-near-seashore-1142948/','public',3);


-- Insert data into tblRating
insert into tblRating(newsId,userId,rating) values
(4,1,7),
(5,1,8),
(6,1,7),
(4,2,5),
(5,2,7),
(6,2,4),
(4,4,7),
(5,4,8);

-- Insert data into tblTag
insert into tblTag(newsId,tag) values
(4,'sports'),
(5,'politics'),
(6,'technology'),
(4,'international'),
(5,'business'),
(6,'sports'),
(4,'technology'),
(5,'sports');


-- Insert data into tblComment

insert into tblComment(newsId,userId,comment) values
(4,1,'This is a very good news about sports. It reveals a lot.'),
(5,2,'This news enlightened me about the current political situation of this country.'),
(6,3,'The new technologies invented by this people is great and will improve peoples life.'),
(4,4,'Is this the reason behind that international incident.'),
(5,5,'The market price of the products is too high. Someone needs to do something.'),
(6,1,'The players plays such good football. He will shine in the next game for sure.'),
(4,2,'I hope this technology comes to my country soon. I am really looking forward to it.'),
(5,5,'Hope he gets well by next game and comes back to playing in full form.');