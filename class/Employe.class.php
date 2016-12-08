<?php
/**
 *
 * @see        Utilisateur
 */
USE Utilisateur;

class Employe extends Utilisateur {

	/**
	 * 
	 * @var int
	 * @access private
	 */
	private  $idEmploye;

	/**
	 * 
	 * @var int
	 * @access private
	 */
	private  $droits;

	/**
	 * 
	 * @var int
	 * @access private
	 */
	private  $idLivreur;


	/**
	 * @access public
	 * @return int
	 */

	public  function getDroits() {
        return $this->droits;
	}


	/**
	 * @access public
	 * @return int
	 */

	public  function getIdLivreur() {
        return $this->idLivreur;
	}


	/**
	 * @access public
	 * @param int $droits 
	 * @return void
	 */

	public  function setDroits($droits) {
        $this->droits = $droits;
	}


	/**
	 * @access public
	 * @param int $idLivreur 
	 * @return void
	 */

	public  function setIdLivreur($idLivreur) {
        $this->idLivreur = $idLivreur;
	}


}
?>