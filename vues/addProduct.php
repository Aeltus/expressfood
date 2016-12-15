<?php
/**
 * Created by PhpStorm.
 * User: Davis
 * Date: 15/12/2016
 * Time: 18:50
 */


/*Traitement du fichier
======================================================================================================================*/

if ($_FILES['photo']['error'] > 0)
{
    echo 'Problème : ';
    switch ($_FILES['photo']['error'])
    {
        case 1:   echo 'Le fichier dépasse upload_max_filesize';
            break;
        case 2:   echo 'Le fichier dépasse max_file_size';
            break;
        case 3:   echo 'Dépôt incomplet';
            break;
        case 4:   echo 'Le dépôt n\a pas été effectué';
            break;
        case 6:   echo 'Dépôt impossible : vous n\'avez pas indiqué de répertoire temporaire.';
            break;
        case 7:   echo 'Echec du dépôt : impossible d\écrire sur le disque.';
            break;
    }
    exit;
}

// Placement du fichier à l'emplacement désiré
$fichier = 'vues/assets/img/plats/'.$_FILES['photo']['name'];

if (is_uploaded_file($_FILES['photo']['tmp_name']))
{
    if (!move_uploaded_file($_FILES['photo']['tmp_name'], $fichier))
    {
        echo 'Problème : Impossible de déplacer le fichier dans son répertoire de destination';
        exit;
    }
}
else
{
    echo 'Problème : Attaque possible par le fichier ';
    echo $_FILES['photo']['name'];
    exit;
}


$produit = new Produit(NULL, $_POST['denomination'], $_POST['description'], $_FILES['photo']['name'], 1, (int)$_POST['prix'], (int)$_POST['type']);

$req = new ProductManager();
$req->addProduct($produit);

$_SESSION['message-ok'] = "Produit ajouté";

ServiceProvider::newPage(ServiceProvider::setRoute('gestionProduits'));

/*====================================================================================================================*/