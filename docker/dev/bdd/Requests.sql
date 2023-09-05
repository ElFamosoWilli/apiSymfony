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
SELECT departement.departement_nom , departement.departement_code
FROM departement 
INNER JOIN villes_france_free ON departement.departement_code =  villes_france_free.ville_departement ;

