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

/* création d'un objet Client||Employe||Livreur depuis le formulaire
======================================================================================================================*/
    // si numero est renseigné, c'est un client
    if(isset($_POST['numero'])){
        $user = new Client(NULL, $_POST['nom'], $_POST['prenom'], $_POST['mail'], $_POST['password1'], NULL, NULL, 1, $_POST['numero'], $_POST['rue'], $_POST['codePostal'], $_POST['ville']);

    // si il à des droits c'est un employe
    } elseif (isset($_POST['droits'])){

        // si il a un attribut dispo, c'est un livreur
        if($_POST['droits'] == "3"){
            $user = new Livreur(NULL, $_POST['nom'], $_POST['prenom'], $_POST['mail'], $_POST['password1'], NULL, NULL, 1, $_POST['droits'], NULL, $_POST['locationLat'], $_POST['locationLong'], $_POST['villeRatach'], 1);

        //sinon, c'est un simple employe
        } else {
            $user = new Employe(NULL, $_POST['nom'], $_POST['prenom'], $_POST['mail'], $_POST['password1'], NULL, NULL, 1, $_POST['droits']);
        }


    }

/*====================================================================================================================*/

/* Création du nouvel utilisateur en BDD
======================================================================================================================*/

    $req = new UserManager();
    $req->addUser($user);

/*====================================================================================================================*/

/* Message de confirmation ou d'erreur
======================================================================================================================*/

    $_SESSION['message-ok'] = "Inscription réussie";
} else {
    $_SESSION['message-erreur'] = "Les deux mots de passes ne correspondent pas";
}

/*====================================================================================================================*/
switch ($_SESSION['role']){
    case "client":
        ServiceProvider::newPage(ServiceProvider::setRoute('accueil'));
        break;
    case "admin":
        ServiceProvider::newPage(ServiceProvider::setRoute('gestionEmployes'));
        break;
}

