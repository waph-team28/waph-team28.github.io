DROP TABLE IF EXISTS `messages`;
CREATE TABLE messages(
 sender varchar(50),
 FOREIGN KEY (sender) REFERENCES `users`(`username`),
 receiver varchar(50),
 FOREIGN KEY (receiver) REFERENCES `users`(`username`),
 messageContent varchar(100) NOT NULL,
 timeCreated DATETIME DEFAULT CURRENT_TIMESTAMP);