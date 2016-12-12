<?php
/**
 *
 * @see        DAO
 */


class ProductManager extends DAO {


	/**
	 * @access public
	 * @param int $idProduit 
	 * @return object Produit
     *
     * Récupère un produit dans la BDD
	 */

	public  function getProduct($idProduit) {

        $produitPDO = $this->pdoMysqlQuery("SELECT * FROM produits WHERE id_produit=".$idProduit);
        $produit = $produitPDO->fetch();
        return $this->productCreator($produit);

	}


	/**
	 * @access public
	 * @return object[array] Produit
     *
     * Récupère une liste contenant tous les produits en vente dans la BDD
	 */

	public  function getProducts() {
       $produitsPDO = $this->pdoMysqlQuery("SELECT * FROM produits WHERE visible='1' ORDER BY type DESC");
       $produits = [];

       while ($produit = $produitsPDO->fetch()){
           $produitObject = $this->productCreator($produit);
           $produits[] = $produitObject;
       }

       return $produits;
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


    /**
     * @param $produit => array données PDO
     * @return Produit
     */
    public function productCreator($produit){

        return new Produit($produit['id_produit'], $produit['nom'],$produit['description'], $produit['photo'], $produit['visible'], $produit['prix'], $produit['type']);

    }

}

