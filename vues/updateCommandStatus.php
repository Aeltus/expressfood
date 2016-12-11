<?php
/**
 * Created by PhpStorm.
 * User: Davis
 * Date: 11/12/2016
 * Time: 18:13
 */


/* Récupération de la commande
======================================================================================================================*/

$req = new CommandManager();
$commandes = $req->getCommandByRef($_POST['refCommande']);

/*====================================================================================================================*/

/* Modification des objets pour ajouter la date de livraison
======================================================================================================================*/

$now = new DateTime('NOW');
$dateLivraison = $now->format('Y-m-d H:m:s');
foreach ($commandes as $commande){
    $commande->setDateLivraison($dateLivraison);
}

/*====================================================================================================================*/

/* Mise à jour de la commande en BDD
======================================================================================================================*/

$req->updateCommand($commandes);

/*====================================================================================================================*/

/* Mise à jour du statut du livreur en disponible
======================================================================================================================*/

$req = new UserManager();
$livreur = $req->getLivreurById($_SESSION['utilisateur']->getLivreurId());
$livreur->setDispo("1");
$req->updateUser($livreur);

/*====================================================================================================================*/

ServiceProvider::newPage(ServiceProvider::setRoute('adminAccueil'));
