<?php

class Produit {

	/**
	 * 
	 * @var int
	 * @access private
	 */
	private  $idProduit;

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
	private  $description;

	/**
	 * 
	 * @var string
	 * @access private
	 */
	private  $photo;

	/**
	 * 
	 * @var boolean
	 * @access private
	 */
	private  $visible;

	/**
	 * 
	 * @var float
	 * @access private
	 */
	private  $prix;

	/**
	 * 
	 * @var int
	 * @access private
	 */
	private  $type;


	/**
	 * @access public
	 * @param int $idProduit 
	 * @param string $nom 
	 * @param string $description 
	 * @param string $photo 
	 * @param boolean $visible 
	 * @param int $type 
	 * @return void
	 */

	public  function __construct($idProduit = NULL, $nom, $description, $photo, $visible = 1, $prix, $type) {
        $this->idProduit = $idProduit;
        $this->setNom($nom);
        $this->setDescription($description);
        $this->setPhoto($photo);
        $this->setVisible($visible);
        $this->setPrix($prix);
        $this->setType($type);
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
	 * @return string
	 */

	public  function getNom() {
        return $this->nom;
	}


	/**
	 * @access public
	 * @return string
	 */

	public  function getDescription() {
        return $this->description;
	}


	/**
	 * @access public
	 * @return string
	 */

	public  function getPhoto() {
        return $this->photo;
	}


	/**
	 * @access public
	 * @return int
	 */

	public  function getVisible() {
        return $this->visible;
	}


	/**
	 * @access public
	 * @return float
	 */

	public  function getPrix() {
        return $this->prix;
	}


	/**
	 * @access public
	 * @return int
	 */

	public  function getType() {
        return $this->type;
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
	 * @param string $description 
	 * @return void
	 */

	public  function setDescription($description) {
        $this->description = $description;
	}


	/**
	 * @access public
	 * @param string $photo 
	 * @return void
	 */

	public  function setPhoto($photo) {
        $this->photo = $photo;
	}


	/**
	 * @access public
	 * @param boolean $visible 
	 * @return void
	 */

	public  function setVisible($visible) {
        $this->visible = $visible;
	}


	/**
	 * @access public
	 * @param float $prix 
	 * @return void
	 */

	public  function setPrix($prix) {
        $this->prix = $prix;
	}


	/**
	 * @access public
	 * @param int $type
	 * @return void
	 */

	public  function setType($type) {
        $this->type = $type;
	}


}
?>