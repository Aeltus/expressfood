<?php
/**
 *
 * @see        Utilisateur
 */

class Employe extends Utilisateur {

	/**
	 * 
	 * @var int
	 * @access private
	 */
	private  $idEmploye = NULL;

	/**
	 * 
	 * @var int
	 * @access private
	 */
	private  $droits = NULL;

	/**
	 * 
	 * @var int
	 * @access private
	 */
	private  $idLivreur = NULL;

	function __construct($idUtilisateur, $nom, $prenom, $mail, $motDePasse, $idEmploye, $idClient, $visible, $droits, $idLivreur=NULL)
    {
        parent::__construct($idUtilisateur, $nom, $prenom, $mail, $motDePasse, $idEmploye, $idClient, $visible);
        $this->setDroits($droits);
        $this->setIdLivreur($idLivreur);
    }


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