<?php
/**
 *
 * @see        DAO
 */
USE DAO;

class CommandManager extends DAO {


	/**
	 * @access public
	 * @param string $refCommande 
	 * @return object
     *
     * Récupère une commande dans la BDD
	 */

	public  function getCommand($refCommande) {

	}


	/**
	 * @access public
	 * @return object[array]
     *
     * Récupère toutes les commandes (sur les 30 derniers jours) de la BDD
	 */

	public  function getCommands() {

	}


	/**
	 * @access public
	 * @param object $command 
	 * @return void
     *
     * Ajoute une commande en BDD
	 */

	public  function addCommand($command) {

	}


	/**
	 * 	
	 * @access public
	 * @param object $command 
	 * @return void
     *
     * Met à jour une commande
	 */

	public  function updateCommand($command) {

	}


	/**
	 * @access public
	 * @param string $refCommande 
	 * @return void
     *
     * efface une commande dont la ref == $refCommande
	 */

	public  function deleteCommand($refCommande) {

	}

    /**
     * @access public
     * @param string $refCommande
     * @return void
     *
     *Associe un livreur à une commande
     */

    public  function attribuLivreur($refCommande, $idLivreur) {

    }


}
?>