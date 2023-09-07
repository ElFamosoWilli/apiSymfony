-- supression de la function 
DROP FUNCTION if exists euroLib ; 

-- création de la function de formatage 
DELIMITER $$
CREATE FUNCTION euroLib(valeur INTEGER) RETURNS VARCHAR(50)
BEGIN
    RETURN concat_ws(' ',ROUND((valeur / 100),2), 'euros');
END 
$$
DELIMITER ;