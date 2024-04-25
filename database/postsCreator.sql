
DROP TABLE IF EXISTS `posts`;
CREATE TABLE posts(
postid int AUTO_INCREMENT PRIMARY KEY,
 postOwner varchar(50),
 FOREIGN KEY (postOwner) REFERENCES `users`(`username`),
 postContent varchar(100) NOT NULL,
 timeCreated DATETIME DEFAULT CURRENT_TIMESTAMP);
