<?php

class commande {

	/**
	 * 
	 * @var int
	 * @access private
	 */
	private  $idUtilisateur;

	/**
	 * 
	 * @var int
	 * @access private
	 */
	private  $idProduit;

	/**
	 * 
	 * @var int
	 * @access private
	 */
	private  $quantite;

	/**
	 * 
	 * @var string
	 * @access private
	 */
	private  $refCommande;

	/**
	 * 
	 * @var int
	 * @access public
	 */
	private  $idLivreur = NULL;

    /**
     *
     * @var object
     * @access private
     */
    private  $dateCommande;

    /**
     *
     * @var object
     * @access private
     */
    private  $dateLivraison;


	/**
	 * @access private
	 * @param int $idUtilisateur 
	 * @param int $idProduit 
	 * @param int $quantite 
	 * @param string $refCommande 
	 * @return void
	 */

	function __construct($idUtilisateur, $idProduit, $quantite, $refCommande, $IdLivreur=NULL, $dateCommande=NULL, $dateLivraison=NULL) {
        $this->setIdUtilisateur($idUtilisateur);
        $this->setIdProduit($idProduit);
        $this->setQuantite($quantite);
        $this->setRefCommande($refCommande);
        $this->setIdLivreur($IdLivreur);
        $this->setDateCommande($dateCommande);
        $this->setDateLivraison($dateLivraison);
	}


	/**
	 * @access public
	 * @return int
	 */

	public  function getIdUtilisateur() {
        return $this->idUtilisateur;
	}


	/**
	 * @access public
	 * @return int
	 */

	public  function getIdProduit() {
        return $this->idProduit;
	}


	/**
	 * @access public
	 * @return int
	 */

	public  function getQuantite() {
        return $this->quantite;
	}


	/**
	 * @access public
	 * @return string
	 */

	public  function getRefCommande() {
        return $this->refCommande;
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
     * @return object
     */

    public  function getDateLivraison() {
        return $this->dateLivraison;
    }

    /**
     * @access public
     * @return object
     */

    public  function getDateCommande() {
        return $this->dateCommande;
    }


	/**
	 * @access public
	 * @param int $idUtilisateur 
	 * @return void
	 */

	public  function setIdUtilisateur($idUtilisateur) {
        $this->idUtilisateur = $idUtilisateur;
	}


	/**
	 * @access public
	 * @param int $idProduit 
	 * @return void
	 */

	public  function setIdProduit($idProduit) {
        $this->idProduit = $idProduit;
	}


	/**
	 * @access public
	 * @param int $quantite 
	 * @return void
	 */

	public function setQuantite($quantite) {
        $this->quantite = $quantite;
	}


	/**
	 * @access public
	 * @param int $idLivreur 
	 * @return void
	 */

	public  function setIdLivreur($idLivreur) {
        $this->idLivreur = $idLivreur;
	}

    /**
     * @access public
     * @return void
     */

    public  function setDateLivraison($dateLivraison) {
        $this->dateLivraison = $dateLivraison;
    }

    /**
     * @access public
     * @return void
     */

    public  function setDateCommande($dateCommande) {
        $this->dateCommande = $dateCommande;
    }

    /**
     * @param string $refCommande
     */
    public function setRefCommande($refCommande)
    {
        $this->refCommande = $refCommande;
    }
}
?>