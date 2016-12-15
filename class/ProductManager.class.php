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

	public  function getProducts($visible = 1) {
       $produitsPDO = $this->pdoMysqlQuery("SELECT * FROM produits WHERE visible='".$visible."' ORDER BY type DESC");
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

	    $query = "INSERT INTO produits SET ";
	    $query .= "nom='".$Produit->getNom()."', ";
        $query .= "description='".$Produit->getDescription()."', ";
        $query .= "photo='".$Produit->getPhoto()."', ";
        $query .= "visible=".$Produit->getVisible().", ";
        $query .= "prix=".$Produit->getPrix().", ";
        $query .= "type=".$Produit->getType();


        $this->pdoMysqlQuery($query);
	}


	/**
	 * @access public
	 * @param int $idProduit, int $visible
	 * @return void
     *
     * met à jour la visibilité d'un produit
	 */

	public function updateProduct($idProduit, $visible) {

    $query = "UPDATE produits SET visible=".$visible." WHERE id_produit=".$idProduit;

    $this->pdoMysqlQuery($query);

	}



    /**
     * @param $produit => array données PDO
     * @return Produit
     */
    public function productCreator($produit){

        return new Produit($produit['id_produit'], $produit['nom'],$produit['description'], $produit['photo'], $produit['visible'], $produit['prix'], $produit['type']);

    }

}

