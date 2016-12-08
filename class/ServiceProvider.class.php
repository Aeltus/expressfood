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

    /**
     *
     * return void
     *
     * détruit la session
     */
    public static function deconnecte(){
        session_destroy();
    }

    /**
     *
     * return void
     *
     * détruit la session et renvoie à l'accueil
     */
    public static function connecte(){
        session_start();
    }

}