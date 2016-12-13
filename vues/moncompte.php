<div class="row">
    <div class="col-md-6 text-center">

        <h2>Vos informations de contact</h2>
        <?php

        echo $_SESSION['utilisateur']->getNom()." ".$_SESSION['utilisateur']->getPrenom()."<br />";
        if (method_exists($_SESSION['utilisateur'], 'getNumero')){
            echo $_SESSION['utilisateur']->getNumero()." ".$_SESSION['utilisateur']->getRue()."<br />";
            echo $_SESSION['utilisateur']->getCodePostal()." ".$_SESSION['utilisateur']->getVille()."<br />";
        }
        echo $_SESSION['utilisateur']->getMail()."<br />";

        ?>
        <br />
        <a href="<?php echo ServiceProvider::setRoute('updateInfos') ?>">Modifier mes informations</a>   |   <a href="<?php echo ServiceProvider::setRoute('updatePassword') ?>">Modifier mon mot de passe</a>   |   <a href="index.php?content=effacerClient&id=<?php echo $_SESSION['utilisateur']->getIdUtilisateur() ?>">Supprimer mon compte</a>
        <br />

    </div>

    <?php
    //le recap des commandes ne saffiche que pour l'utilisateur client les autres ne commandent pas
    if ($_SESSION['role'] == "client"){
    ?>

    <hr>
    <div class="col-md-6 text-center">

        <h2>Vos commandes</h2>
    <?php
    $req = new CommandManager();
    $commandes = $req->getCommandsByIdClient($_SESSION['utilisateur']->getIdUtilisateur());
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

    //Si il n'y a pas d'historique on affiche un texte
    if (!isset($statut)) {

        echo "<h4>Vous n'avez pas d'historique de commandes</h4>";

    }

    echo "</div>";
}

echo "</div>";