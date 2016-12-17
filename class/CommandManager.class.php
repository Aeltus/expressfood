<?php
/**
 *
 * @see        DAO
 */

class CommandManager extends DAO {

    /**
     * @param $idClient
     * @return Client array
     */
    public function getCommandsByIdClient($idClient)
    {
        $query = "SELECT * FROM commande WHERE utilisateur_id_utilisateur=".$idClient." ORDER BY date_commande DESC";

        $commandesPDO = $this->pdoMysqlQuery($query);
        $commandesArray = [];
        while ($commande = $commandesPDO->fetch()){
            $commandesArray[] = $this->commandObjectCreator($commande);
        }

        return $commandesArray;
    }


    /**
     * @param $idLivreur
     * @return object array
     */
    public function getCommandByLivreur($idLivreur){
        $query = "SELECT * FROM commande WHERE livreur_id_livreur=".$idLivreur." AND ISNULL(date_livraison)=1";


        $resultat = $this->pdoMysqlQuery($query);
        $commande = [];

        while ($donnees = $resultat->fetch()){

            $commande[] = $this->commandObjectCreator($donnees);

        }

        return $commande;
    }


	/**
	 * @access public
	 * @param string $refCommande 
	 * @return object array
     *
     * Récupère une commande dans la BDD
	 */

	public  function getCommandByRef($refCommande) {
        $query = "SELECT * FROM commande WHERE ref_commande=".$refCommande;


        $resultat = $this->pdoMysqlQuery($query);
        $commande = [];

        while ($donnees = $resultat->fetch()){

            $commande[] = $this->commandObjectCreator($donnees);

        }

        return $commande;
	}

	/**
	 * @access public
	 * @param array object Command
	 * @return void
     *
     * Ajoute une commande en BDD
	 */

	public  function addCommand($commandArray) {

	    $query = "INSERT INTO commande VALUES ";
	    $i=0;

	    foreach ($commandArray as $command){
	        if ($i > 0){
	            $query .= ", ";
            }
            $i++;
	        $query .= "(".$command->getIdUtilisateur().", ".$command->getIdProduit().", ".$command->getQuantite().", '".$command->getRefCommande()."', ".$command->getIdLivreur().", '".$command->getDateCommande()->format('Y-m-d H:m:s')."', NULL)";
        }

        $this->pdoMysqlQuery($query);

	}


	/**
	 * 	
	 * @access public
	 * @param object array $command
	 * @return void
     *
     * Met à jour une commande
	 */

	public  function updateCommand($commands) {

        $this->pdoMysqlQuery('START TRANSACTION');

        foreach ($commands as $command){

            $query = "UPDATE commande SET";
            $query .= " quantite=".$command->getQuantite().", livreur_id_livreur=".$command->getIdLivreur().", date_commande='".$command->getDateCommande();
            $query .= "', date_livraison='".$command->getDateLivraison()."' ";
            $query .= "WHERE ref_commande=".$command->getRefCommande()." AND produits_id_produit=".$command->getIdProduit();

            $this->pdoMysqlQuery($query);

        }

        $this->pdoMysqlQuery('COMMIT');
        $_SESSION['message-ok'] = "Mise à jour de la commande effectué";


	}


    /**
     * @param array $commande
     * @return string
     */
    public function getStatut($commande){
        if ($commande->getDateLivraison() != NULL){
            $statut = "Livré le : ".$commande->getDateLivraison();
        } else {
            $statut = "Livraison en cours";
        }
        return $statut;
    }

    /**
     *
     * @param $commande => array de données PDO
     * @return commande
     *
     */
    public function commandObjectCreator($commande){

       return new commande($commande['utilisateur_id_utilisateur'], $commande['produits_id_produit'], $commande['quantite'], $commande['ref_commande'], $commande['livreur_id_livreur'], $commande['date_commande'],$commande['date_livraison']);

    }


}
?>