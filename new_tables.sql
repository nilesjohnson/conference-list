CREATE TABLE tags 
(
id INT NOT NULL AUTO_INCREMENT, 
PRIMARY KEY(id),
name varchar(255)
);

create table conferences_tags(
id int not null auto_increment,
primary key(id),
conference_id int,
tag_id int
);