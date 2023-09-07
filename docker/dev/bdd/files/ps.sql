-- procedure stocké de calcule de ca 

-- suppression de la procédure 
DROP PROCEDURE IF EXISTS  afficheCA ;

-- creation de notre procedure de calcule 
DELIMITER | 
CREATE PROCEDURE afficheCA()
    BEGIN
        select euroLib(sum( (pu * quantite) * 1.2) / 100) from ligne_facture;
    END 
|
DELIMITER ;  
