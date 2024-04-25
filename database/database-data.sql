DROP TABLE IF EXISTS `users`;
CREATE TABLE users(
 username varchar(50) PRIMARY KEY,
 password varchar(100) NOT NULL,
 name varchar(50) NOT NULL,
 phone varchar(20) NOT NULL,
 email varchar(20) NOT NULL,
 additionalEmail varchar(20) NOT NULL,
 role bool default true);

LOCK TABLES `users` WRITE;
INSERT INTO users(username, password, name, phone, email, additionalEmail) VALUES('team28',
md5('RiddleStars'), 'team28', '9999999999', 'team28@mail.uc.edu', 'riddle@mail.uc.edu');
UNLOCK TABLES;
