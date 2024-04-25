drop table if exists superusers;
CREATE TABLE superusers(
 username varchar(50) PRIMARY KEY,
 password varchar(100) NOT NULL);

LOCK TABLES `superusers` WRITE;
INSERT INTO superusers(username, password) VALUES('devaravo',
md5('Devara@1234'));
UNLOCK TABLES;

