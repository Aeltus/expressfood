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
        <a href="<?php echo ServiceProvider::setRoute('updateInfos') ?>">Modifier mes informations</a>   |   <a href="<?php echo ServiceProvider::setRoute('updatePassword') ?>">Modifier mon mot de passe</a>
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
    $commandEnCours = "";
    $totalCommande = 0;
    $dateEnCours = "";
    $contenu = "";
    $i = 0;
    $totalLignes = count($commandes);

    foreach ($commandes as $commande) {

        // Si on change de Ref commande on affiche
        if ($commandEnCours !== $commande->getRefCommande() && $i > 0) {
            echo "<br /><h4>Commande N° " . $commandEnCours . " du " . $dateEnCours . " Statut : " . $statut . "</h4>";

            echo "<table><tr><th>Produit</th><th>Quantité</th><th>Prix</th></tr>";
            echo $contenu;
            echo "<tr><td colspan='2'>Total</td><td>" . $totalCommande . "</td></tr>";
            echo "</table>";
            $contenu = "";
            $totalCommande = 0;

        }

        $req = new ProductManager();
        $produit = $req->getProduct($commande->getIDProduit());

        $req = new CommandManager();
        $statut = $req->getStatut($commande);

        $commandEnCours = $commande->getRefCommande();
        $dateEnCours = $commande->getDateCommande();
        $totalCommande += $produit->getPrix();

        //Création du contenu du tableau avec la nouvelle commande
        ob_start();

        echo "<tr><td>" . $produit->getNom() . "</td><td>" . $commande->getQuantite() . "</td><td>" . $produit->getPrix() . "</td></tr>";

        $contenu .= ob_get_contents();
        ob_end_clean();


        $i++;

        //Si dernière ligne on affiche
        if ($i == $totalLignes) {
            echo "<br /><h4>Commande N° " . $commandEnCours . " du " . $dateEnCours . " Statut : " . $statut . "</h4>";

            echo "<table><tr><th>Produit</th><th>Quantité</th><th>Prix</th></tr>";
            echo $contenu;
            echo "<tr><td colspan='2'>Total</td><td>" . $totalCommande . "</td></tr>";
            echo "</table>";
            $contenu = "";
            $totalCommande = 0;
        }
    }

    //Si il n'y a pas d'historique on affiche un texte
    if (!isset($statut)) {

        echo "<h4>Vous n'avez pas d'historique de commandes</h4>";

    }

    echo "</div>";
}

echo "</div>";