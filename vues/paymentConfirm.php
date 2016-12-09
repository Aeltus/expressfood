<?php
/**
 * Created by PhpStorm.
 * User: Davis
 * Date: 08/12/2016
 * Time: 21:39
 */

$req = new UserManager();
$infosLivraison = $req->trouveLivreur($_SESSION['utilisateur']);

/*
 *  RESULTAT :
 *  $infosLivraison = [];
    $infosLivraison += array("livreur" => $idLivreurChoisi);
    $infosLivraison += array("duree" => $dureStr);
    $infosLivraison += array("distance" => $distance);


    TODO :
    retrouver le livreur depuis son id => mail pour le prévenir
*   faire l'enregistrement en BDD => reset panier => redirect accueil.
 *
 *
*/



echo "L'id du livreur choisi est : ".$infosLivraison['livreur']." il se trouve actuellement à ".$infosLivraison['distance']." et sera chez vous d'ici ".$infosLivraison['duree'];