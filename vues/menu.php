<div class="row">

    <!-- Affichage des plats
    =================================================================================================================-->
    <div class="col-md-12 text-center">
        <h1>Faites votre choix</h1>
    </div>

        <?php

        $req = new ProductManager();
        $produits = $req->getProducts();

        foreach ($produits as $produit){
        ?>
            <div class="col-md-3 text-center">
                <h2><?php echo $produit->getNom(); ?></h2> <!-- Titre du plat -->
                <p><?php echo $produit->getDescription(); ?></p> <!-- description du plat -->
                <img src="vues/assets/img/plats/<?php echo $produit->getPhoto(); ?>" class="produitIMG"> <!-- Photo du plat -->
                <p><?php echo sprintf('%.2f',$produit->getPrix()); ?> euros</p> <!-- Tarif du plat -->
                <form method="post" action="index.php?action=addPanier">
                    <label for="qtiteProduit">Quantité :&nbsp</label><input type="text" value="0" name="qtiteProduit" size="2">
                    <input type="hidden" name="idProduit" value="<?php echo $produit->getIdProduit(); ?>">
                    <input type="submit" value="ajouter au panier">
                </form>
            </div>
            <?php
        }
        ?>
    <!--=============================================================================================================-->

</div>