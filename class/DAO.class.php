<?php

class DAO {

	/**
	 * 
	 * @var
	 * @access private
	 */
	private  $bdd;


	/**
	 * @access private
	 * @return void
     *
     * Récupère les infos de connection à la BDD dans le fichier de config, et établi la connection
	 */

	function __construct() {
        $contenuFichier = file_get_contents("conf/config.json");

        $json = json_decode ($contenuFichier);

        try {

            //connection

            $bdd = new PDO('mysql:host='.$json->dbHost.';dbname='.$json->dbName.';charset=utf8', $json->dbLogin, $json->dbPass);

        }
        catch(Exception $e){

            // En cas d'erreur, en enregistre le message d'erreur, et on arrete tout

            $_SESSION['message-erreur']= "Une erreur est survenue lors de la connection à la base de données, merci de reessayer un peu plus tard.<br /> Désolé pour le dérangement<br />Message : ".$e->getMessage();
            die('Oups une erreur est survenue');

        }

	    $this->bdd = $bdd;
	}



	/**
	 * @access public
	 * @param string $query
	 * @return *
     *
     * exécute la requette reçue en paramettre
	 */

	public  function pdoMysqlQuery($query) {

	    $reponse = $this->bdd->query($query);

        return $reponse;

	}


}
?>