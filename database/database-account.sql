
create database if not exists waph_team;
drop user if exists 'team28'@'localhost';
CREATE USER  'team28'@'localhost' IDENTIFIED BY 'RiddleStars';
GRANT ALL ON waph_team.* TO 'team28'@'localhost';


