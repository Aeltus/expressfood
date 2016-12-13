<?php
/**
 * Created by PhpStorm.
 * User: Davis
 * Date: 10/12/2016
 * Time: 21:04
 *
 *
 */

/* Création de l'entité à modifier
======================================================================================================================*/

if (isset($_GET['id'])){

    $req = new UserManager();
    $utilisateur = $req->getUtilisateurById($_GET['id']);

} else {

    $utilisateur = $_SESSION['utilisateur'];

}


/*====================================================================================================================*/


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
    $utilisateur->setNom($_POST['nom']);
    $utilisateur->setPrenom($_POST['prenom']);
    $utilisateur->setMail($_POST['mail']);
    $_SESSION['message-ok'] = "Le compte à bien été mis à jour";
}
if (isset($_POST['dispo'])){
    if ($_POST['dispo'] == "on"){
        $dispo = 1;
    }
    $utilisateur->setDispo($dispo);
}
if (isset($_POST['locationLat'])){
    $utilisateur->setLocationLat($_POST['locationLat']);
    $utilisateur->setLocationLong($_POST['locationLong']);
    $utilisateur->setVilleRatach($_POST['villeRatach']);
}
if (isset($_POST['droits'])){
    $utilisateur->setDroits($_POST['droits']);
}
if (isset($_POST['rue'])){
    $utilisateur->setNumero($_POST['numero']);
    $utilisateur->setRue($_POST['rue']);
    $utilisateur->setCodePostal($_POST['codePostal']);
    $utilisateur->setVille($_POST['ville']);
}

/*====================================================================================================================*/

/* Mise à jour de l'entité en BDD
======================================================================================================================*/
$req = new UserManager();
$req->updateUser($utilisateur);

/*====================================================================================================================*/


ServiceProvider::newPage(ServiceProvider::setRoute($_SESSION['routeActuelle']));
