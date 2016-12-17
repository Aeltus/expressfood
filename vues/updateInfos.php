<div class="row">
    <div class="col-md-12 text-center">

        <form  method="post" action="index.php?content=userUpdate">

            <span><h3>Modifiez vos informations de contact</h3></span>
            <br />
            <label for="nom">Nom : </label><input type="text" value="<?php echo $_SESSION['utilisateur']->getNom(); ?>" name="nom" id="nom" required>
            <label for="prenom">Prenom : </label><input type="text" value="<?php echo $_SESSION['utilisateur']->getPrenom(); ?>" name="prenom" id="prenom" required><br />
            <label for="mail">Mail : </label><input size=30 type="text" value="<?php echo $_SESSION['utilisateur']->getMail(); ?>" name="mail" id="mail" required><br />


            <?php
            $_SESSION['routeActuelle'] = "moncompte";
            // si l'utilisateur à des droits c'est donc un employe
            if (method_exists($_SESSION['utilisateur'], 'getDroits')){
                // si c'est un livreur
                if($_SESSION['utilisateur']->getDroits() == 3) {
                    ?>
                    <hr>
                    <span><h3>Modifiez votre disponibilité :</h3></span>
                    <br />
                    <label for="dispo">Je suis disponible</label><input type="checkbox" name="dispo" id="dispo"><br />

                    <?php
                }
            } else { // sinon, c'est un client

            ?>
            <hr>
            <h3>Modifiez votre adresse :</h3>
            <br />
            <label for="numero">Numero : </label><input type="text" value="<?php echo $_SESSION['utilisateur']->getNumero(); ?>" name="numero" id="numero" required>
            <label for="rue">Rue : </label><input type="text" value="<?php echo $_SESSION['utilisateur']->getRue(); ?>" name="rue" id="rue" required><br />
            <label for="codePostal">Code postal : </label><input type="text" value="<?php echo $_SESSION['utilisateur']->getCodePostal(); ?>" name="codePostal" id="codePostal" required>
            <label for="ville">Ville : </label><input type="text" value="<?php echo $_SESSION['utilisateur']->getVille(); ?>" name="ville" id="ville" required><br />


            <?php

            }

            ?>



            <input type="submit" value="Valider">

        </form>

    </div>

</div>
