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

ServiceProvider::sessionStart();

/*====================================================================================================================*/

/* Gère les actions
======================================================================================================================*/

if (isset($_GET['action'])){
    ServiceProvider::actionLoader($_GET['action']);
    die();
}


/*====================================================================================================================*/


/*Controlle si on demande à afficher un panier vide, affiche message et redirige vers la page de commande
======================================================================================================================*/

if($_SESSION['content'] == "vues/affichePanier.php"){
    if(count($_SESSION['panier'])<1){
        $_SESSION['message-warning'] = 'Vous n\'avez aucun produit dans votre panier';
        $route = ServiceProvider::setRoute('menu');
        ServiceProvider::newPage($route);
    }
}

/*====================================================================================================================*/



/* Gère les redirections
======================================================================================================================*/

if (isset($_GET['route'])) {

    $_SESSION['content'] = ServiceProvider::router($_GET['route']);
    ServiceProvider::newPage();

}

/*====================================================================================================================*/


/*Création de la page et affichage
======================================================================================================================*/

ob_start();

require_once('vues/header.php');
echo ServiceProvider::getAlerts();
require_once($_SESSION['content']);
require_once('vues/footer.php');

$page = ob_get_contents();
ob_end_clean();

echo $page;


/*====================================================================================================================*/
