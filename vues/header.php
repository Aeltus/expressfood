<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <title>Express Food - Accueil</title>

    <meta name="description" content="Le site de la maison de l'architecture">

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style type="text/css"> </style>

    <link rel="stylesheet" id="style-perso-css" href="vues/assets/css/styles.css" type="text/css" media="all">




</head>


<body>

<div class="div-identification text-center">
    <form  method="post" action="index.php?action=identifier">
        <div id="close-btn" class="text-right"><a href="/">FERMER -<i class="fa fa-times" aria-hidden="true"></i></a></div>
        <span><h1>Saisissez votre login / mot de passe</h1></span>
        <br />
        <input type="text" placeholder="adresse mail" size="30" name="mail" required>
        <input type="password" placeholder="mot de passe" name="password" required>
        <input type="submit" value="Valider">
    </form>

</div>

<header class="row">

    <!-- Navigation
    ================================================== -->
    <nav class="nav navbar h100">
        <div class="container flex-around h100">

            <!-- Logo
            ================================================== -->
            <div class="col-md-2 flex-middle h100 flex-center">
                <a href="/"><img class="logo" src="vues/assets/img/logo.jpg"></a>
            </div>

            <!-- Menu
            ================================================== -->
            <div class="col-md-8 flex-center h100">
                <div class="row h100">

                    <div class="col-md-12 h100">
                        <ul class="nav navbar-nav">



                            <!-- Affichage conditionnel des options du menu
                            =============================================================================================-->
                            <?php
                            // Menu utilisateur anonyme
                            if($_SESSION['role'] == "anonyme"){
                                echo '<li class="menu-btn"><a href="'.ServiceProvider::setRoute("accueil").'">ACCUEIL</a></li>';
                                echo '<li class="menu-btn"><a href="'.ServiceProvider::setRoute("menu").'">NOS MENUS</a></li>';
                                echo'<li class="menu-btn"><a href="#" class="identification">S\'IDENTIFIER</a></li>';
                                echo '<li class="menu-btn"><a href="' . ServiceProvider::setRoute('affichePanier') . '">Panier / Commander (';

                                if (isset($_SESSION['panier'])) {
                                    echo count($_SESSION['panier']);
                                } else {
                                    echo "0";
                                }

                                echo ')</a></li>';

                            // Menu client
                            } else if($_SESSION['role']=='client') {
                                echo '<li class="menu-btn"><a href="'.ServiceProvider::setRoute("accueil").'">ACCUEIL</a></li>';
                                echo '<li class="menu-btn"><a href="'.ServiceProvider::setRoute("menu").'">NOS MENUS</a></li>';
                                echo '<li class="menu-btn"><a href="' . ServiceProvider::setRoute('monCompte') . '">Mon Compte</a></li>';
                                echo '<li class="menu-btn"><a href="' . ServiceProvider::setRoute('accueil') . '&action=deconnecter">(Se déconnecter)</a></li>';
                                echo '<li class="menu-btn"><a href="' . ServiceProvider::setRoute('affichePanier') . '">Panier / Commander (';

                                if (isset($_SESSION['panier'])) {
                                    echo count($_SESSION['panier']);
                                } else {
                                    echo "0";
                                }

                                echo ')</a></li>';

                                // Menu commun employe
                            } else {

                                echo '<li class="menu-btn"><a href="' . ServiceProvider::setRoute('adminAccueil') . '">Accueil</a></li>';

                                // Menu administrateur
                                if($_SESSION['role']=='admin') {

                                    echo '<li class="menu-btn"><a href="' . ServiceProvider::setRoute('gestionEmployes') . '">Gestion des employés</a></li>';
                                    echo '<li class="menu-btn"><a href="' . ServiceProvider::setRoute('gestionVentes') . '">Gestion des ventes</a></li>';

                                    // Menu service client
                                } else if($_SESSION['role']=='service') {

                                    echo '<li class="menu-btn"><a href="' . ServiceProvider::setRoute('gestionClients') . '">Gestion des clients</a></li>';
                                    echo '<li class="menu-btn"><a href="' . ServiceProvider::setRoute('gestionProduits') . '">Gestion des produits</a></li>';

                                    // Menu livreur
                                } else if ($_SESSION['role']=='livreur'){

                                    echo '<li class="menu-btn"><a href="' . ServiceProvider::setRoute('livraisons') . '">Mes livraisons</a></li>';

                                }

                                echo '<li class="menu-btn"><a href="' . ServiceProvider::setRoute('monCompte') . '">Mon Compte</a></li>';
                                echo '<li class="menu-btn"><a href="' . ServiceProvider::setRoute('accueil') . '&action=deconnecter">(Se déconnecter)</a></li>';

                            }
                            ?>

                        </ul>
                    </div>
                </div>
            </div>
    </nav>
    <hr>
</header>