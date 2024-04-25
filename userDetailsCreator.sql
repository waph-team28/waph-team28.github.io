
DROP TABLE IF EXISTS `userDetails`;
CREATE TABLE userDetails(
 name varchar(50) NOT NULL,
 username varchar(50),
 FOREIGN KEY (username) REFERENCES `users`(`username`),
 phone varchar(20),
 email varchar(20),
 additionalEmail varchar(20));