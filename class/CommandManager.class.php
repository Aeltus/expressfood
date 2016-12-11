<?php
/**
 *
 * @see        DAO
 */

class CommandManager extends DAO {

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
	 * @access public
	 * @param string $refCommande 
	 * @return object
     *
     * Récupère une commande dans la BDD
	 */

	public  function getCommandByRef($refCommande) {

	}


	/**
	 * @access public
	 * @return object[array]
     *
     * Récupère toutes les commandes (sur les 30 derniers jours) de la BDD
	 */

	public  function getCommands() {

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
	 * @param object $command 
	 * @return void
     *
     * Met à jour une commande
	 */

	public  function updateCommand($command) {

	}


	/**
	 * @access public
	 * @param string $refCommande 
	 * @return void
     *
     * efface une commande dont la ref == $refCommande
	 */

	public  function deleteCommand($refCommande) {

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

    public function commandObjectCreator($commande){
       return new commande($commande['utilisateur_id_utilisateur'], $commande['produits_id_produit'], $commande['quantite'], $commande['ref_commande'], $commande['livreur_id_livreur'], $commande['date_commande'],$commande['date_livraison']);
    }


}
?>