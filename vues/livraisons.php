<?php
/**
 * Created by PhpStorm.
 * User: Davis
 * Date: 11/12/2016
 * Time: 17:23
 */

$req = new CommandManager();


echo "<div class='row'>";

if ($commande = $req->getCommandByLivreur($_SESSION['utilisateur']->getLivreurId())){
    echo "<h3>Voici votre commande à livrer</h3><br />";
    echo "<h4>Adresse :</h4><br />";

    $obj = new UserManager();
    $client = $obj->getUtilisateurById($commande[0]->getIdUtilisateur());

    echo $client->getNom()." ".$client->getPrenom()."<br />";
    echo $client->getNumero()." ".$client->getRue()."<br />";
    echo $client->getCodePostal()." ".$client->getVille()."<br />";

    echo "<hr><h4>Commande :</h4><br />";
    echo "<div class='col-md-6'><table><tr><th>Produit</th><th>Quantité</th></tr>";

    foreach ($commande as $ligne){

        $req = new ProductManager();

        echo "<tr><td>".$req->getProduct($ligne->getIdProduit())->getNom()."</td><td>".$ligne->getQuantite()."</td></tr>";
        $refCommande = $ligne->getRefCommande();

    }

    echo "</table></div>";
    echo "<div class='col-md-6'>";
    echo "<form method='post' action='index.php?content=updateCommandStatus'><input type='hidden' value='".$refCommande."' name='refCommande'><input type='submit' class='btn btn-primary' value='Livré !!!'></form>";
    echo "</div>";

} else {

    echo "<h3>Vous n'avez pas de commande à livrer</h3>";

}

echo "</div>";
