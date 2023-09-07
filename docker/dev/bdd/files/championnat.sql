
use Championnat;
-- CREATE TABLE IF NOT EXISTS classement(
-- id int(11) AUTO_INCREMENT PRIMARY KEY,
-- equipe VARCHAR(150) NOT NULL,
-- nbr_point int(3) not null,
-- but_pour int(4) not null,
-- but_contre int(4) not null
-- );

-- CREATE TABLE IF NOT EXISTS rencontre(
-- id int(11) AUTO_INCREMENT PRIMARY KEY,
-- equipe_a int(11) NOT NULL,
-- score_a int(4) not null,
-- equipe_b int(11) NOT NULL,
-- score_b int(4) not null,
-- constraint FK_equipe_a foreign key (equipe_a) REFERENCES classement(id),
-- constraint FK_equipe_b foreign key (equipe_b) REFERENCES classement(id)
-- );

-- insert into classement (equipe,nbr_point,but_pour,but_contre) 
-- VALUES('OM',0,0,0),('OL',0,0,0),('PSG',0,0,0),('FC Toulouse',0,0,0),
-- ('LOSC',0,0,0);

-- alter table classement add unique index nom_equipe(equipe);
-- alter table classement drop index nom_equipe ;

insert into rencontre(equipe_a,score_a,equipe_b,score_b) VALUES(1,3,2,2);
