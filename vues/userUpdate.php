<?php
/**
 * Created by PhpStorm.
 * User: Davis
 * Date: 10/12/2016
 * Time: 21:04
 *
 *
 */

/* Modification de l'entité si modification du mot de passe
======================================================================================================================*/

if (isset($_POST['lastPass'])) {

    if ($_POST['lastPass'] == $_SESSION['utilisateur']->getMotDePasse()) {

        if ($_POST['password1'] == $_POST['password2']) {

            $_SESSION['utilisateur']->setMotDePasse($_POST['password1']);
            $_SESSION['message-ok'] = "Votre mot de passe à bien été modifié";


        } else {
            $_SESSION['message-erreur'] = "Les nouveaux mots de passe ne correspondent pas";
            ServiceProvider::newPage(ServiceProvider::setRoute('updatePassword'));
            die();
        }
    } else {
        $_SESSION['message-erreur'] = "Votre ancien mot de passe n'est pas bon";
        ServiceProvider::newPage(ServiceProvider::setRoute('updatePassword'));
        die();
    }
}


/*====================================================================================================================*/


/* Modification de l'entité si modification des données Utilisateurs ou Client
======================================================================================================================*/
if (isset($_POST['nom'])){
    $_SESSION['utilisateur']->setNom($_POST['nom']);
    $_SESSION['utilisateur']->setPrenom($_POST['prenom']);
    $_SESSION['utilisateur']->setMail($_POST['mail']);
    $_SESSION['message-ok'] = "Votre compte à bien été mis à jour";
}
if (isset($_POST['dispo'])){
    $_SESSION['utilisateur']->setDispo($_POST['dispo']);
}
if (isset($_POST['rue'])){
    $_SESSION['utilisateur']->setNumero($_POST['numero']);
    $_SESSION['utilisateur']->setRue($_POST['rue']);
    $_SESSION['utilisateur']->setCodePostal($_POST['codePostal']);
    $_SESSION['utilisateur']->setVille($_POST['ville']);
}




/*====================================================================================================================*/

/* Mise à jour de l'entité en BDD
======================================================================================================================*/
$req = new UserManager();
$req->updateUser($_SESSION['utilisateur']);

/*====================================================================================================================*/


ServiceProvider::newPage(ServiceProvider::setRoute('moncompte'));
