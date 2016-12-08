<?php
/**
 *
 * @see        DAO
 */
USE DAO;

class UserManager extends DAO {


	/**
	 * @access public
	 * @param object $client 
	 * @param object[array] $livreurs 
	 * @return object
     *
     * connection à l'API de GOOGLE MAPS pour trouver dans la ville,  le livreur le plus proche du point de livraison
	 */

	public function trouveLivreur( $client,  $livreurs) {
    /* Cette méthode utilise l' API de GOOGLE Maps pour trouver dans la ville,  le livreur le plus proche du point de livraison
    =============================================================================================================================*/

    /*===========================================================================================================================*/
	}


	/**
	 * @access public
	 * @param int $idLivreur 
	 * @return object
     *
     * trouve un livreur en BDD
	 */

	public  function getLivreurById($idLivreur) {

	}


	/**
	 * @access public
	 * @return object[array]
     *
     * Récupère en BDD une liste des utlisateurs
	 */

	public  function getUsers() {

	}


	/**
	 * @access public
	 * @param string $login 
	 * @param string $motDePasse 
	 * @return object
     *
     * Identifie un tulisateur avec son identifiant et son mot de passe, puis construit la session Utilisateur correspondante
	 */

	public  function identifyUser($login, $motDePasse) {

	}


	/**
	 * @access public
	 * @param int $idUtilisateur 
	 * @return void
     *
     * Ajoute un utilisateur en BDD
	 */

	public  function addUser($idUtilisateur) {

	}


	/**
	 * @access public
	 * @param int $idUtilisateur 
	 * @return void
     *
     * Efface un utilisateur de la BDD (rend invisible)
	 */

	public final  function deleteUser($idUtilisateur) {

	}


	/**
	 * @access public
	 * @param object $Utilisateur 
	 * @return void
     *
     * Met à jour un utilisateur
	 */

	public final  function updateUser( $Utilisateur) {

	}


}
?>