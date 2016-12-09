<?php
/**
 *
 * @see        DAO
 */


class ProductManager extends DAO {


	/**
	 * @access public
	 * @param int $idProduit 
	 * @return object
     *
     * Récupère un produit dans la BDD
	 */

	public  function getProduct($idProduit) {
        return $this->pdoMysqlQuery("SELECT * FROM produits WHERE id_produit=".$idProduit);
	}


	/**
	 * @access public
	 * @return object[array]
     *
     * Récupère un liste contenant tous les produits en vente dans la BDD
	 */

	public  function getProducts() {
       return $this->pdoMysqlQuery("SELECT * FROM produits WHERE visible='1' ORDER BY type DESC");
	}


	/**
	 * @access public
	 * @param object $Produit 
	 * @return void
     *
     * ajoute un produits en BDD
	 */

	public  function addProduct( $Produit) {

	}


	/**
	 * @access public
	 * @param int $idProduit 
	 * @return void
     *
     * efface un produit en BDD
	 */

	public function deleteProduct($idProduit) {

	}


	/**
	 * @access public
	 * @param object $Produit 
	 * @return void
     *
     * met à jour un produit en BDD
	 */

	public final  function updateProduct( $Produit) {

	}


}
?>