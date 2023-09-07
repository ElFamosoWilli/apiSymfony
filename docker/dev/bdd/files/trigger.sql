-- --suppression du trigger si il existe
-- DROP TRIGGER IF EXISTS journee ;
-- --creation du trigger 
-- DELIMITER //
-- CREATE TRIGGER journee
-- AFTER INSERT
-- ON rencontre 
-- FOR EACH ROW 
--     UPDATE classement 
--         set 
--             nbr_point= nbr_point +3 , 
--             but_pour = but_pour + NEW.score_a,
--             but_contre = but_contre + NEW.score_b
--         WHERE id = NEW.equipe_a;
-- //
-- DELIMITER ; 


DROP TRIGGER IF EXISTS moyenne ; 

DELIMITER //
CREATE TRIGGER moyenne
AFTER INSERT 
ON Evaluation
FOR EACH ROW
    UPDATE Eleve
        set 
            moyenne  = (
            SELECT AVG(evaluation)
            FROM Evaluation 
            WHERE id_eleve = NEW.id_eleve
            )
            WHERE id = NEW.id_eleve ; 
            
//
DELIMITER ; 

INSERT INTO Evaluation (label_matiere,matiere_id,id_eleve,date_evaluation,evaluation)
VALUES ('math',1,1,now(),17);