<?php
/**
 * Created by PhpStorm.
 * User: Davis
 * Date: 11/12/2016
 * Time: 19:28
 */

/* Vérification de concordance des deux mots de passe
======================================================================================================================*/

if ($_POST['password1'] == $_POST['password2']) {

/*====================================================================================================================*/

/* création d'un objet Client depuis le formulaire
======================================================================================================================*/

    $client = new Client(NULL, $_POST['nom'], $_POST['prenom'], $_POST['mail'], $_POST['password1'], NULL, NULL, 1, $_POST['numero'], $_POST['rue'], $_POST['codePostal'], $_POST['ville']);

/*====================================================================================================================*/

/* Création du nouvel utilisateur en BDD
======================================================================================================================*/

    $req = new UserManager();
    $req->addUser($client);

/*====================================================================================================================*/

/* Message de confirmation ou d'erreur
======================================================================================================================*/

    $_SESSION['message-ok'] = "Inscription réussie, vous pouvez dès à présent vous connecter";
} else {
    $_SESSION['message-erreur'] = "Les deux mots de passes ne correspondent pas";
}

/*====================================================================================================================*/

ServiceProvider::newPage(ServiceProvider::setRoute('accueil'));
