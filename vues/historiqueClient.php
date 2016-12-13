<?php
/**
 * Created by PhpStorm.
 * User: Davis
 * Date: 13/12/2016
 * Time: 20:35
 */

echo "<div class='row'><div class='col-md-6 text-center'> ";
/* Constitution de la liste des commandes depuis l'id du client
======================================================================================================================*/

$req = new CommandManager();
$commandes = $req->getCommandsByIdClient($_GET['id']);

/*====================================================================================================================*/

/* Parcours de la liste et création du tableau
======================================================================================================================*/

$commandeActuelle = "";
$i = 0;
$prixtotal = 0;

foreach ($commandes as $commande){

    // 1ere ligne
    if ($commandeActuelle !== $commande->getRefCommande()) {

        if ($i > 0){
            echo "<tr><td colspan='3'><strong>TOTAL : </strong></td><td>".$prixtotal."</td></tr></table><br />";
            $prixtotal = 0;
        }


        if ($commande->getDateLivraison() == NULL) {
            $statut = "Livraison en cours";
        } else {
            $statut = "Livré le : " . $commande->getDateLivraison();
        }

        $commandeActuelle = $commande->getRefCommande();

        echo "<h4>Commande N° " . $commande->getRefCommande() . " du " . $commande->getDateCommande() . " Statut : " . $statut."</h4>";
        echo "<table><tr><th>Produit</th><th>Quantité</th><th>Prix unitaire</th><th>Total ligne</th></tr>";

    }

    $req = new ProductManager();
    $produit = $req->getProduct($commande->getIdProduit());

    $tarifLigne = $produit->getPrix() * $commande->getQuantite();
    $prixtotal += $tarifLigne;

    echo "<tr><td>".$produit->getNom()."</td><td>".$commande->getQuantite()."</td><td>".$produit->getPrix()."</td><td>".$tarifLigne."</td></tr>";


    $i++;

}

echo "<tr><td colspan='3'><strong>TOTAL : </strong></td><td>".$prixtotal."</td></tr></table><br />";

/*====================================================================================================================*/

echo "</div></div>";
