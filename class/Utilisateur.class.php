<?php

class Utilisateur {

	/**
	 * 
	 * @var int
	 * @access private
	 */
	private  $idUtilisateur;

	/**
	 * 
	 * @var string
	 * @access private
	 */
	private  $nom;

	/**
	 * 
	 * @var string
	 * @access private
	 */
	private  $prenom;

	/**
	 * 
	 * @var string
	 * @access private
	 */
	private  $mail;

	/**
	 * 
	 * @var string
	 * @access private
	 */
	private  $motDePasse;

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
	private  $idClient;

    /**
     *
     * @var boolean
     * @access private
     */
    private  $visible;


    /**
	 * @access public
	 * @return int
	 */

	public  function getIdUtilisateur() {
        return $this->idUtilisateur;
	}


	/**
	 * @access public
	 * @return string
	 */

	public  function getNom() {
        return $this->nom;
	}


	/**
	 * @access public
	 * @return string
	 */

	public  function getPrenom() {
        return $this->prenom;
	}


	/**
	 * @access public
	 * @return string
	 */

	public  function getMail() {
        return $this->mail;
	}


	/**
	 * @access public
	 * @return string
	 */

	public  function getMotDePasse() {
        return $this->motDePasse;
	}


	/**
	 * @access public
	 * @return int
	 */

	public  function getIdEmploye() {
        return $this->idEmploye;
	}


	/**
	 * @access public
	 * @return int
	 */

	public function getIdClient() {
        return $this->idClient;
	}

    /**
     * @access public
     * @return boolean
     */

    public function getVisible() {
        return $this->visible;
    }



    /**
     * @access public
     * @param string $idUtilisateur
     * @return void
     */

    public function setIdUtilisateur($idUtilisateur) {
        $this->idUtilisateur = $idUtilisateur;
    }



	/**
	 * @access public
	 * @param string $nom 
	 * @return void
	 */

	public  function setNom($nom) {
        $this->nom = $nom;
	}


	/**
	 * @access public
	 * @param string $prenom 
	 * @return void
	 */

	public  function setPrenom($prenom) {
        $this->prenom = $prenom;
	}


	/**
	 * @access public
	 * @param string $mail 
	 * @return void
	 */

	public  function setMail($mail) {
        $this->mail = $mail;
	}


	/**
	 * @access public
	 * @param string $motDePasse 
	 * @return void
	 */

	public  function setMotDePasse($motDePasse) {
        $this->motDePasse = $motDePasse;
	}


	/**
	 * @access public
	 * @param int $idEmploye 
	 * @return void
	 */

	public function setIdEmploye($idEmploye) {
        $this->idEmploye = $idEmploye;
	}


	/**
	 * @access public
	 * @param int $idCLient 
	 */

	public function setIdClient($idCLient) {
        $this->idClient = $idCLient;
	}

    public function setVisible($visible = 1) {
        $this->idClient = $visible;
    }


}
?>