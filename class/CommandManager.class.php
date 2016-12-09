<?php
/**
 *
 * @see        DAO
 */

class CommandManager extends DAO {


	/**
	 * @access public
	 * @param string $refCommande 
	 * @return object
     *
     * Récupère une commande dans la BDD
	 */

	public  function getCommand($refCommande) {

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
     * @access public
     * @param string $refCommande
     * @return void
     *
     *Associe un livreur à une commande
     */

    public  function attribuLivreur($refCommande, $idLivreur) {

    }


}
?>