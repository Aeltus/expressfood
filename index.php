<?php
/**
 * Created by PhpStorm.
 * User: Davis
 * Date: 05/12/2016
 * Time: 21:17
 */


/* Autoloader
======================================================================================================================*/
function autoload($classname)
{
    if (file_exists('class/' . $classname . '.class.php')) {
        require('class/' . $classname . '.class.php');
    } else {
        echo 'fichier : class/' . $classname . '.class.php introuvable.';
        die();
    }
}

spl_autoload_register('autoload');

/*====================================================================================================================*/



/* Ouverture de session + paramétrage par défaut
======================================================================================================================*/

ServiceProvider::connecte();


if (!isset($_SESSION['content'])){
    $_SESSION['content'] = "vues/accueil.html";
}
if (!isset($_SESSION['role'])){
    $_SESSION['role'] = "anonyme";
}

/*====================================================================================================================*/



/*Controlle si on demande à afficher un panier vide, affiche message et redirige vers la page de commande
======================================================================================================================*/

if($_SESSION['content'] == "vues/affichePanier.php"){
    if(count($_SESSION['panier'])<1){
        $_SESSION['message-warning'] = 'Vous n\'avez aucun produit dans votre panier';
        ServiceProvider::setRoute('menu');
        ServiceProvider::newPage();
    }
}

/*====================================================================================================================*/



/* Actions préalables à l'affichage
======================================================================================================================*/

// gère les redirections
if (isset($_GET['route'])){
    if (file_exists ('vues/'.$_GET['route'].'.php')){
        $routeComplete = 'vues/'.$_GET['route'].'.php';
    } else  if (file_exists ('vues/'.$_GET['route'].'.htm')){
        $routeComplete = 'vues/'.$_GET['route'].'.htm';
    } else  if (file_exists ('vues/'.$_GET['route'].'.html')){
        $routeComplete = 'vues/'.$_GET['route'].'.html';
    } else {
        $_SESSION['message-erreur'] = "Les pages :<br />     - vues/".$_GET['route'].".php<br />     - vues/".$_GET['route'].".html<br />     - vues/".$_GET['route'].".htm<br /> n'existent pas. Merci de vérifier l'adresse.";
        $routeComplete = '404.php';
    }
    $_SESSION['content'] = $routeComplete;

    ServiceProvider::newPage();
    die();
}

// gère les actions
if (isset($_GET['action'])){
    switch ($_GET['action']){

        case "deconnecter":
            ServiceProvider::deconnecte();

            ServiceProvider::newPage();
            break;

        die();
    }
}


/*====================================================================================================================*/



/*Création de la page et affichage
======================================================================================================================*/

ob_start();

require_once('vues/header.php');
echo ServiceProvider::getAlerts();
include($_SESSION['content']);
include('vues/footer.php');

ob_end_flush();

/*====================================================================================================================*/
