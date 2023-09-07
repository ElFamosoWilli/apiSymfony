use Lidem ; 
CREATE TABLE IF NOT EXISTS niveau(
   id_niveau INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
   label VARCHAR(100) NOT NULL
);

ALTER TABLE Eleve 
ADD COLUMN moyenne float NOT NULL ;

--supression de la function 
DROP FUNCTION if exists nomPrenom ; 

--création de la function de formatage 
DELIMITER $$
CREATE FUNCTION nomPrenom(nom CHAR(50) , prenom CHAR(50)) RETURNS VARCHAR(350)
BEGIN
    RETURN upper(concat_ws(' ',nom,prenom));
END 
$$
DELIMITER ;

--création d'un fonction qui format la date de naissance sous la forme 
-- --: 'lundi 11 décembre 1997'
DROP FUNCTION IF EXISTS dateFormatLib ; 

DELIMITER $$
CREATE FUNCTION dateFormatLib(datetoformat date) RETURNS VARCHAR(150)
BEGIN
   RETURN date_format(datetoformat,' %a %D %M %Y') ;
END
$$
DELIMITER ;

SELECT nomPrenom(nom,prenom) as NomPrenom , dateFormatLib(date_de_naissance) as date_de_naiss
FROM Eleve ; 

CREATE TABLE IF NOT EXISTS Evaluation
(
    evaluation_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    label_matiere VARCHAR(150) NOT NULL,
    matiere_id int NOT NULL,
    id_eleve int NOT NULL,
    date_evaluation date NOT NULL,
    evaluation float NOT NULL
);
