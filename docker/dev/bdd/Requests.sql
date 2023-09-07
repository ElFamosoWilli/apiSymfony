-- Obtenir la liste des 10 villes les plus peuplées en 2012
select ville_nom ,  ville_population_2012 from villes_france_free ORDER BY ville_population_2012 DESC LIMIT 10 ;
-- Obtenir la liste des 50 villes ayant la plus faible superficie
select ville_surface , ville_nom from villes_france_free ORDER BY ville_surface ASC LIMIT 50 ;
-- Obtenir la liste des départements d’outres-mer, c’est-à-dire ceux dont le numéro de département commencent par “97”
select departement_code from departement WHERE departement_code LIKE '%97%'
-- Obtenir la liste des 10 villes les plus peuplées en 2012 ainsi que le nom des départements associés 
select villes_france_free.ville_nom, villes_france_free.ville_population_2012 ,departement.departement_nom
from villes_france_free
INNER JOIN departement ON villes_france_free.ville_departement = departement.departement_code
ORDER BY ville_population_2012 DESC LIMIT 10 ;
-- Obtenir la liste du nom de chaque département, 
-- associé à son code et du nombre de commune au sein de ces département, 
-- en triant afin d’obtenir en priorité les départements qui possèdent le plus de communes
SELECT departement.departement_nom , departement.departement_code , count(departement.departement_nom) as cnt
FROM departement 
INNER JOIN villes_france_free ON departement.departement_code =  villes_france_free.ville_departement 
GROUP BY departement.departement_nom, departement.departement_code ORDER BY cnt DESC;

-- Obtenir la liste des 10 plus grands départements, en terme de superficie
SELECT departement.departement_nom , sum(villes_france_free.ville_surface) as cnt
FROM departement 
INNER JOIN villes_france_free ON departement.departement_code =  villes_france_free.ville_departement 
GROUP BY departement.departement_nom  ORDER BY cnt DESC LIMIT 10;

-- Compter le nombre de villes dont le nom commence par “Saint” 
SELECT COUNT(ville_nom) AS cnt FROM villes_france_free WHERE ville_nom LIKE 'Saint-%' ;

-- Obtenir la liste des villes qui ont un nom existants plusieurs fois, et trier afin d’obtenir 
-- en premier celles dont le nom est le plus souvent utilisé par plusieurs communes
SELECT ville_nom , count(ville_nom) AS cnt FROM villes_france_free GROUP BY ville_nom 
ORDER BY cnt DESC;

-- Obtenir en une seule requête SQL la liste des villes dont la superficie est supérieur à la superficie moyenne
SELECT ville_surface , ville_nom
FROM villes_france_free 
WHERE ville_surface > (
SELECT avg(ville_surface) as moyenne
FROM villes_france_free) ;

--Obtenir la liste des départements qui possèdent plus de 2 millions d’habitants
SELECT departement.departement_nom ,sum(villes_france_free.ville_population_2012) as habitants
FROM departement 
INNER JOIN villes_france_free ON departement.departement_code = villes_france_free.ville_departement 
GROUP BY departement.departement_nom 
HAVING habitants > 2000000 ;

--Remplacez les tirets par un espace vide, pour toutes les villes commençant par “SAINT-” (dans la colonne qui contient les noms en majuscule)
SELECT REPLACE ( ville_nom , '-', ' ') as nom
FROM villes_france_free ;