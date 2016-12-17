<div class='row'>
    <div class='col-md-12 text-center'>
        <a href="<?php echo ServiceProvider::setRoute('ajoutEmploye') ?>"> <div class="btn btn-primary">Ajouter un employe </div></a>

        <h2>Gestion des employes</h2>

        <!--Affichage de la liste des employés
        =====================================================================================================================-->

        <table>
            <tr><th>ID</th><th>Nom / Prenom</th><th>Mail</th><th>Droits</th><th>Modifier</th><th>Effacer</th></tr>

            <?php
            $_SESSION['routeActuelle'] = "gestionEmployes";
            // récupération des utilisateurs de type employe
            $req = new UserManager();
            $users = $req->getUsers('employe');

            // constitution du tableau
            foreach ($users as $user){

                switch ($user->getDroits()){

                    case 1:
                        $droits = "Administrateur";
                        break;
                    case 2:
                        $droits ="Service client";
                        break;
                    case 3:
                        $droits = "Livreur";
                        break;

                }

                echo "<tr><td>".$user->getIdUtilisateur()."</td><td>".$user->getNom()." ".$user->getPrenom()."</td><td>".$user->getMail()."</td><td>".$droits;
                echo "</td><td><a href='index.php?content=updateUser&id=".$user->getIdUtilisateur()."'>modifier</a></td><td><a href='index.php?content=effacerUser&id=".$user->getIdUtilisateur()."'>effacer</a></td></tr>";
            }

            ?>



        </table>

        <!--=================================================================================================================-->


    </div></div>
