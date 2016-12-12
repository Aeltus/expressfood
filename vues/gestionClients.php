<div class='row'>
<div class='col-md-12 text-center'>
<h2>Gestion des clients</h2>

<!--Affichage de la liste de clients
=====================================================================================================================-->

    <table>
        <tr><th>ID</th><th>Nom / Prenom</th><th>Adresse</th><th>mail</th><th>Historique commandes</th><th>Modifier</th><th>Effacer</th></tr>

        <?php

        // récupération des utilisateurs de type client
        $req = new UserManager();
        $users = $req->getUsers('client');

        // constitution du tableau
        foreach ($users as $user){
            echo "<tr><td>".$user->getIdUtilisateur()."</td><td>".$user->getNom()." ".$user->getPrenom()."</td><td>".$user->getNumero()." ".$user->getRue()."<br />".$user->getCodePostal()." ".$user->getVille()."</td><td>".$user->getMail();
            echo "</td><td><a href='index.php?content=historiqueClient&id=".$user->getIdUtilisateur()."'>voir</a></td><td><a href='index.php?content=modifierClient&id=".$user->getIdUtilisateur()."'>modifier</a></td><td><a href='index.php?content=effacerClient&id=".$user->getIdUtilisateur()."'>effacer</a></td></tr>";
        }

        ?>



    </table>

<!--=================================================================================================================-->


</div></div>
