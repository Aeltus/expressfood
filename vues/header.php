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
    <form  method="post" action="<?php echo ServiceProvider::setRoute('identifie'); ?>">
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
                            <li class="menu-btn"><a href="<?php echo ServiceProvider::setRoute('accueil'); ?>">ACCUEIL</a></li>
                            <li class="menu-btn"><a href="<?php echo ServiceProvider::setRoute('menu'); ?>">NOS MENUS</a></li>

                            <!-- Affichage conditionnel des options du menu
                            =============================================================================================-->
                            <?php
                            if($_SESSION['role'] == "anonyme"){
                                echo'<li class="menu-btn"><a href="#" class="identification">S\'IDENTIFIER</a></li>';
                            } else if($_SESSION['role']=='admin' or $_SESSION['role']=='service' or $_SESSION['role']=='livreur'){
                                echo'<li class="menu-btn"><a href="'.ServiceProvider::setRoute('accueil').'">Administration</a></li>';
                                echo'<li class="menu-btn"><a href="'.ServiceProvider::setRoute('deconnecte').'?action=deconnecter">(Se déconnecter)</a></li>';
                            } else if($_SESSION['role']=='client'){
                                echo'<li class="menu-btn"><a href="'.ServiceProvider::setRoute('monCompte').'">Mon Compte</a></li>';
                                echo'<li class="menu-btn"><a href="'.ServiceProvider::setRoute('deconnecte').'?action=deconnecter">(Se déconnecter)</a></li>';
                            }

                            ?>
                            <li class="menu-btn"><a href="<?php echo ServiceProvider::setRoute('affichePanier'); ?>">Panier / Commander (
                                    <?php

                                    if (isset($_SESSION['panier'])){
                                        echo count($_SESSION['panier']);
                                    } else {
                                        echo "0";
                                    }


                                    ?> )</a></li>
                        </ul>
                    </div>
                </div>
            </div>
    </nav>
    <hr>
</header>