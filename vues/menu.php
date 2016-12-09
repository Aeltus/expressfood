<div class="row">

    <!-- Affichage des plats
    =================================================================================================================-->
    <div class="col-md-12 text-center">
        <h1>Faites votre choix</h1>
    </div>

        <?php

        $req = new ProductManager();
        $reponse = $req->getProducts();

        while ($plats = $reponse->fetch()){
        ?>
            <div class="col-md-3 text-center">
                <h2><?php echo $plats['nom']; ?></h2> <!-- Titre du plat -->
                <p><?php echo $plats['description']; ?></p> <!-- description du plat -->
                <img src="vues/assets/img/plats/<?php echo $plats['photo']; ?>" class="produitIMG"> <!-- Photo du plat -->
                <p><?php echo sprintf('%.2f',$plats['prix']); ?> euros</p> <!-- Tarif du plat -->
                <form method="post" action="index.php?action=addPanier">
                    <label for="qtiteProduit">Quantité :&nbsp</label><input type="text" value="0" name="qtiteProduit" size="2">
                    <input type="hidden" name="idProduit" value="<?php echo $plats['id_produit']; ?>">
                    <input type="submit" value="ajouter au panier">
                </form>
            </div>
            <?php
        }
        ?>
    <!--=============================================================================================================-->

</div>