<?php

/**
 * Created by PhpStorm.
 * User: Davis
 * Date: 07/12/2016
 * Time: 22:28
 */
class ServiceProvider
{
    /**
     * @param $route
     *
     * défini la route voulue dans la variable $_SESSION['content'] et revoie l'index
     */
    public static function setRoute($route){

        return 'index.php?route='.$route;
    }


    /**
     * @param string $page
     *
     * Redirection vers $page
     */
    public static function newPage($page = "/"){
        header('location:'.$page);
    }


    /**
     * @return string
     *
     * Affiche les messages d'alerte
     */
    public static function getAlerts(){

        $messages = "";
        $messages .= '<div class="row">';
        if (isset($_SESSION['message'])){
            $messages .= '<div class="col-md-12 text-center alert-info">'.$_SESSION['message'].'</div>';
            $_SESSION['message'] = NULL;
        }
        if (isset($_SESSION['message-ok'])){
            $messages .= '<div class="col-md-12 text-center alert-success">'.$_SESSION['message-ok'].'</div>';
            $_SESSION['message-ok'] = NULL;
        }
        if (isset($_SESSION['message-warning'])){
            $messages .= '<div class="col-md-12 text-center alert-warning">'.$_SESSION['message-warning'].'</div>';
            $_SESSION['message-warning'] = NULL;
        }
        if (isset($_SESSION['message-erreur'])){
            $messages .= '<div class="col-md-12 text-center alert-danger">'.$_SESSION['message-erreur'].'</div>';
            $_SESSION['message-erreur'] = NULL;
        }
        $messages .= '</div>';

        return $messages;

    }


    public static function actionLoader($action){
        if($action == "deconnecter") {

            if (session_destroy()){
                ServiceProvider::newPage();
            } else {
                $_SESSION['message-erreur'] = "Impossible de détruire la session en cours";
            }


        } else if($action == "identifier"){

            $identification = new UserManager();
            $_SESSION['utilisateur'] = $identification->identifyUser($_POST['mail'], $_POST['password']);
            //si l'utilisateur est un employe
            if(method_exists($_SESSION['utilisateur'], 'getDroits')){
                $page = "adminAccueil";
            } else { // sinon, l'utilisateur est un client
                $page = 'accueil';
            }

            ServiceProvider::newPage(ServiceProvider::setRoute($page));


        } else if($action == "addPanier"){
            $ajoutPanier = array($_POST['idProduit'], $_POST['qtiteProduit']);
            if (!isset($_SESSION['panier'])){
                $_SESSION['panier'] = array($_POST['idProduit'] => (int)$_POST['qtiteProduit']);
            } else {
                $_SESSION['panier'][$_POST['idProduit']] = (int)$_POST['qtiteProduit'];
            }
            $_SESSION['message-ok'] = "Ajout au panier réussi";
            ServiceProvider::newPage();


        } else if($action == "deletePanier"){

            $_SESSION['panier'] = NULL;
            $route = ServiceProvider::setRoute('menu');
            ServiceProvider::newPage($route);

        }
    }


    public static function sessionStart(){
        session_start();

        if (!isset($_SESSION['content'])){
            $_SESSION['content'] = "vues/accueil.html";
        }
        if (!isset($_SESSION['role'])){
            $_SESSION['role'] = "anonyme";
        }
    }

    public static function router($route){

            if (file_exists ($_SERVER["DOCUMENT_ROOT"].'/vues/'.$route.'.php')){
                $routeComplete = $_SERVER["DOCUMENT_ROOT"].'/vues/'.$route.'.php';
            } else  if (file_exists ($_SERVER["DOCUMENT_ROOT"].'/vues/'.$route.'.htm')){
                $routeComplete = $_SERVER["DOCUMENT_ROOT"].'/vues/'.$route.'.htm';
            } else  if (file_exists ($_SERVER["DOCUMENT_ROOT"].'/vues/'.$route.'.html')){
                $routeComplete = $_SERVER["DOCUMENT_ROOT"].'/vues/'.$route.'.html';
            } else {
                $_SESSION['message-erreur'] = "Les pages :<br />     - vues/".$route.".php<br />     - vues/".$route.".html<br />     - vues/".$route.".htm<br /> n'existent pas. Merci de vérifier l'adresse.";
                $routeComplete = '/vues/404.html';
            }

        return $routeComplete;

        }



}