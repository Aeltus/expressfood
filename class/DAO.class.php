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

	private final  function __construct() {


	    $this->bdd = $bdd;
	}


	/**
	 * @access public
	 * @return void
     *
     * Ferme la connection à la destruction de la classe
	 */

	public  function __destruct() {

	}


	/**
	 * @access public
	 * @param string $query
	 * @return *
     *
     * exécute la requette reçue en paramettre
	 */

	public final  function pdoMysqlQuery($query) {

	}


}
?>