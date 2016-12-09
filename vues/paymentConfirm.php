<?php
/**
 * Created by PhpStorm.
 * User: Davis
 * Date: 08/12/2016
 * Time: 21:39
 */

/* Cherche le livreur le plus près
======================================================================================================================*/
$req = new UserManager();
$infosLivraison = $req->trouveLivreur($_SESSION['utilisateur']);

/*====================================================================================================================*/

/* Instancie un objet livreur depuis l'ID du livreur sélectionné
======================================================================================================================*/

$livreurObject = new UserManager();
$livreur = $livreurObject->getLivreurById($infosLivraison['livreur']);

/*====================================================================================================================*/

/* Envoie un mail au livreur sélectionné
======================================================================================================================*/

$message = "<h2>Nouvelle livraison pour vous : </h2>";
$message .= "<p><strong>Adresse :</strong></p>";
$message .= "<p>".$_SESSION['utilisateur']->getNom()." ".$_SESSION['utilisateur']->getPrenom()."<br />";
$message .= $_SESSION['utilisateur']->getNumero()." ".$_SESSION['utilisateur']->getRue()."<br />";
$message .= $_SESSION['utilisateur']->getCodePostal()." ".$_SESSION['utilisateur']->getVille()."</p>";
$message .= "<p><strong>Commande :</strong></p>";
$message .= "<div width='600px'><table><tr> <th>Dénomination</th><th>Quantité</th></tr>";

            /* Récupération des informations pour chaque élément du panier + création du tableau
            ==========================================================================================================*/
            $totalPayer = 0;
            foreach($_SESSION['panier'] as $idProduit => $qtiteProduit){


                $req = new ProductManager();
                $reponse = $req->getProduct($idProduit);
                $produit = $reponse->fetch();

                $message .="<tr><td>".$produit['nom']."</td><td>".$qtiteProduit."</td></tr>";

            }

$message .= "</table></div><br />";
$message .= "<p>Merci,</p>";
$message .= "<p>L' équipe d'Express Food</p>";

//mail($livreur->getMail(), "Nouvelle livraison", $message);

/*====================================================================================================================*/

/* Enregistre la commande en BDD + message
======================================================================================================================*/
$_SESSION['message-ok'] = "Votre livreur : ".$livreur->getNom()." ".$livreur->getPrenom()." se trouve actuellement à ".$infosLivraison['distance']." et sera chez vous d'ici ".$infosLivraison['duree'];


$commandArray = [];
$refCommande = $_SESSION['utilisateur']->getIdUtilisateur()."-".date('h-i-s_j-m-y');
$now = new DateTime('NOW');

foreach($_SESSION['panier'] as $idProduit => $qtiteProduit) {

    $curentCommand = new commande($_SESSION['utilisateur']->getIdUtilisateur(), $idProduit, $qtiteProduit, $refCommande, $livreur->getLivreurId(), $now);
    $commandArray[] = $curentCommand;

}

$req = new CommandManager();
$req->addCommand($commandArray);

/*====================================================================================================================*/

/* Efface le panier du client, redirige vers le menu
======================================================================================================================*/


ServiceProvider::newPage(ServiceProvider::setRoute('menu&action=deletePanier'));


/*====================================================================================================================*/

/*
 * TODO
 *
 * Lors de la commande définir le livreur choisi comme non disponible
 *
 */
