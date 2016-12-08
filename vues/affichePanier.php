
<div class="row">

    <div class="col-md-12 text-center">
        <H1>Voici votre panier</H1>
    </div>
    <div class="col-md-6 col-md-offset-3">
        <table class="text-center">
            <tr>
                <th>Dénomination</th>
                <th>P.U. (euros)</th>
                <th>Quantité</th>
                <th>Total TTC</th>
            </tr>

            <?php
            /* Récupération des informations pour chaque élément du panier + création du tableau
            ==========================================================================================================*/
            $totalPayer = 0;
            foreach($_SESSION['panier'] as $idProduit => $qtiteProduit){

                include ('controller/affichePanier.php');
                $produit = $reponse->fetch();
                $payerProduit = $produit['prix'] * $qtiteProduit;
                $totalPayer += $payerProduit;
            ?>

            <tr>
                <td><?php echo $produit['nom']; ?></td>
                <td><?php echo sprintf('%.2f', $produit['prix']); ?></td>
                <td><?php echo $qtiteProduit; ?></td>
                <td><?php echo $payerProduit; ?></td>
            </tr>

            <?php
            }
            ?>

            <tr>
                <td colspan="3"><strong>Total à payer : </strong></td>
                <td><strong><?php echo sprintf('%.2f', $totalPayer); ?></strong></td>
            </tr>

        </table>
    </div>
    <div class="col-md-6 col-md-offset-3 text-center">
        <?php
        if($_SESSION['role'] !== 'client'){
            echo '<h3>Merci de vous identifier sur votre compte client afin de valider votre commande</h3>';
            echo '<p><a href="#" class="identification">S\'IDENTIFER</a> </p>';
        } else {
        ?>
        <div class="col-md-6 text-center">
            <h3>Vérifiez votre adresse</h3>
            <p><?php echo $_SESSION['nom'].' '.$_SESSION['prenom'];?></p>
            <p><?php echo $_SESSION['numero'].' '.$_SESSION['rue'];?></p>
            <p><?php echo $_SESSION['code_postal'].' '.$_SESSION['ville'];?></p>
            <p><?php echo 'mail : '.$_SESSION['mail_utilisateur'];?></p>
            <?php
            if (!isset($_SESSION['refCommande'])){
                $_SESSION['refCommande'] = $_SESSION['id_utilisateur'].'_'.date('h-i-s_j-m-y');
            }
            ?>
            <br /><p><?php echo 'Votre commande portera le N° : '.$_SESSION['refCommande'];?></p>

        </div>
        <div class="col-md-6 text-center">
            <div class="col-md-12 text-center">
                <h3>Paiement</h3>
                <br />
                <form action="controller/commandConfirm.php" method="POST">
                    <script
                            src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                            data-key="pk_test_NG3Imu5SX97XdG0JMvEtCgGC"
                            data-amount="<?php echo $totalPayer*100?>"
                            data-name="Demo ExpressFood"
                            data-description="Widget"
                            data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                            data-locale="fr"
                            data-zip-code="false"
                            data-currency="eur">
                    </script>
                </form>
            </div>
            <div class="col-md-12 text-center top20">
                <a href="controller/deletePanier.php">Annuler le panier</a>
            </div>
        </div>

        <?php
        }
        ?>
    </div>

</div>