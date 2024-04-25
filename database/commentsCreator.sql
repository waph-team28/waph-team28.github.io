
DROP TABLE IF EXISTS `comments`;
CREATE TABLE comments(
 commentOwner varchar(50),
 FOREIGN KEY (commentOwner) REFERENCES `users`(`username`),
 originalPost int,
 FOREIGN KEY (originalPost) REFERENCES `posts`(`postid`),
 commentContent varchar(100) NOT NULL,
 timeCreated DATETIME DEFAULT CURRENT_TIMESTAMP);