<div class="row">

    <div class="col-md-12 text-center">

        <a href="<?php echo ServiceProvider::setRoute('ajoutProduit') ?>"> <div class="btn btn-primary">Ajouter un produit </div></a>

        <h3>Voici la liste des produits affichés : </h3>

        <?php

/*Récupération des produits visibles création de l'affichage
======================================================================================================================*/

        $req = new ProductManager();
        $produits = $req->getProducts();

        echo "<table><tr><th>Dénomination</th><th>Description</th><th>Photo</th><th>Prix</th><th>Supprimer</th></tr>";

        foreach ($produits as $produit){

            echo "<tr><td>".$produit->getNom()."</td><td>".$produit->getDescription()."</td><td><img class='miniPhoto' src='vues/assets/img/plats/".$produit->getPhoto()."'></td><td>".$produit->getPrix()." €</td><td><a href='index.php?content=visibiliteProduit&id=".$produit->getIdProduit()."&visible=0'>Supprimer</a></td></tr>";

        }

        echo "</table>";

/*====================================================================================================================*/
        ?>

        <h3>Voici la liste des anciens produits : </h3>

        <?php

        /*Récupération des produits invisibles création de l'affichage
        ======================================================================================================================*/

        $produits = $req->getProducts(0);

        echo "<table><tr><th>Dénomination</th><th>Description</th><th>Photo</th><th>Prix</th><th>Mettre à la vente</th></tr>";

        foreach ($produits as $produit){

            echo "<tr><td>".$produit->getNom()."</td><td>".$produit->getDescription()."</td><td><img class='miniPhoto' src='vues/assets/img/plats/".$produit->getPhoto()."'></td><td>".$produit->getPrix()." €</td><td><a href='index.php?content=visibiliteProduit&id=".$produit->getIdProduit()."&visible=1'>Mettre à la vente</a></td></tr>";

        }

        echo "</table>";

        /*====================================================================================================================*/
        ?>

    </div>

</div>