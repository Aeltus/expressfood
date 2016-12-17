<?php
/**
 * Created by PhpStorm.
 * User: Davis
 * Date: 12/12/2016
 * Time: 19:05
 */

$req = new UserManager();
$user = $req->getUtilisateurById($_GET['id']);

// on défini l'utilisateur comme non visible, on garde les informations en BDD pour garder l'historique
$user->setVisible('0');

// mise à jour en BDD
$req->updateUser($user);

$_SESSION['message-ok'] = "Le compte à bien été supprimé";

// si le demandeur est le client supprimé on le déconnecte
if($_SESSION['utilisateur']->getIdUtilisateur() == $_GET['id']){

    ServiceProvider::newPage('index.php?route=accueil&action=deconnecter');

} else {

    switch ($_SESSION['role']){

        case "service":
            ServiceProvider::newPage(ServiceProvider::setRoute('gestionClients'));
            break;
        case "admin":
            ServiceProvider::newPage(ServiceProvider::setRoute('gestionEmployes'));
            break;

    }





}
