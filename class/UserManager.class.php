<?php
/**
 *
 * @see        DAO
 */

class UserManager extends DAO {


	/**
	 * @access public
	 * @param object $client
	 * @return array Livreur / string / string
     *
     * recherche les livreurs disponibles dans la ville et
     * connection à l'API de GOOGLE MAPS pour trouver dans la ville,  le livreur le plus proche du point de livraison
	 */

	public function trouveLivreur($client) {
    /* Cette méthode utilise l' API de GOOGLE Maps pour trouver dans la ville,  le livreur le plus proche du point de livraison
     * elle renvoie un tableau contenant l'objet livreur choisi, la distance et la durée de la livraison
    =============================================================================================================================*/

    //infos client
    $adresseClient = $client->getNumero().' '.$client->getRue().' '.$client->getCodePostal().' '.$client->getVille();
    $adresseClient = str_replace(" ", "+", $adresseClient);

    // recup infos livreurs en BDD
    $livreurs = $this->getLivreursByVille($client->getVille());
    $nbrePostulants = 0;
    $idLivreurs = [];

    foreach($livreurs as $livreur){

        if (!isset($coordonnees)){
            $coordonnees = "";
        } else {
            $coordonnees .= "|";
        }
        $coordonnees .= $livreur->getLocationLat().','.$livreur->getLocationLong();
        $nbrePostulants++;
    }

    //envoi requette API GOOGLE
    $contenu_du_fichier = file_get_contents("https://maps.googleapis.com/maps/api/distancematrix/json?origins=".$adresseClient."&destinations=".$coordonnees."&language=fr-FR&key=AIzaSyCFJqwu_dF21beyYKk6c_33MnvvXK3wvGs");
    $json = json_decode ($contenu_du_fichier);


    // on cherche le plus proche à moins de 20 min
    $duree = 1200; //20 min en sec
    $rangLivreurChoisi = -1; // initialise à -1 pour vérifier l'affectation d'un livreur
    $dureStr = "";
    $distance = "";

    for($i=0; $i < $nbrePostulants; $i++){

        if ($duree > (int)$json->rows[0]->elements[$i]->duration->value){

            $rangLivreurChoisi = $i;
            $duree = (int)$json->rows[0]->elements[$i]->duration->value;
            $dureStr = $json->rows[0]->elements[$i]->duration->text;
            $distance = $json->rows[0]->elements[$i]->distance->text;

        }

    }
    if ($rangLivreurChoisi < 0){

        $_SESSION['message-erreur'] = "Aucun livreur actuellement disponible pour vous livrer, nous sommes désolés pour le dérangement";

    } else {

        $livreurChoisi = $livreurs[$rangLivreurChoisi];
    }

    $infosLivraison = [];
    $infosLivraison += array("livreur" => $livreurChoisi);
    $infosLivraison += array("duree" => $dureStr);
    $infosLivraison += array("distance" => $distance);






    return $infosLivraison;

	}

    /**
     *
     * @param $idClient
     * @return Client|Livreur|Employe
     *
     */
    public function getUtilisateurById ($idUtilisateur){
        $query = "SELECT * FROM utilisateur";
        $query .= " ";
        $query .= "LEFT JOIN client ON utilisateur.client_id_client = client.id_client";
        $query .= " ";
        $query .= "LEFT JOIN employe ON utilisateur.employe_id_employe = employe.id_employe";
        $query .= " ";
        $query .= "LEFT JOIN livreur ON employe.livreur_id_livreur = livreur.id_livreur";
        $query .= " ";
        $query .= "WHERE id_utilisateur ='" . $idUtilisateur . "'";
        $query .= " ";
        $query .= "LIMIT 1";


        $livreur = $this->pdoMysqlQuery($query);
        $donnees = $livreur->fetch();


        return $this->userCreator($donnees);

    }

    /**
     *
     * @param string $ville
     * @return array Livreur
     *
     */
    public function getLivreursByVille($ville){

        $query = "SELECT * FROM utilisateur";
        $query .= " ";
        $query .= "LEFT JOIN employe ON utilisateur.employe_id_employe = employe.id_employe";
        $query .= " ";
        $query .= "LEFT JOIN livreur ON employe.livreur_id_livreur = livreur.id_livreur";
        $query .= " ";
        $query .="WHERE ville_ratach='".$ville."' AND dispo=1";

        $livreurs = [];

        $req = $this->pdoMysqlQuery($query);

        while ($donnees = $req->fetch()){

            $livreurs[] = $this->userCreator($donnees);

        }

        return $livreurs;
    }


    /**
     *
     * @param string $type == client || employe
     * @return array Utilisateur
     *
     * liste tout les utilisateurs enregistrés suivant leur type client, ou employe
     */
    public  function getUsers($type) {

        $users = [];

	    // définition de la requete en fonction du type d'utilisateur recherché
        if ($type == "client"){

            $query = "SELECT * FROM utilisateur";
            $query .= " ";
            $query .= "LEFT JOIN client ON utilisateur.client_id_client = client.id_client";
            $query .= " ";
            $query .= "WHERE id_client > 0 AND visible = 1";
            $query .= " ";
            $query .= "ORDER BY id_utilisateur";

        } elseif ($type == "employe"){

            $query = "SELECT * FROM utilisateur";
            $query .= " ";
            $query .= "LEFT JOIN employe ON utilisateur.employe_id_employe = employe.id_employe";
            $query .= " ";
            $query .= "LEFT JOIN livreur ON employe.livreur_id_livreur = livreur.id_livreur";
            $query .= " ";
            $query .= "WHERE id_employe > 0 AND visible = 1";
            $query .= " ";
            $query .= "ORDER BY droits, id_employe";

        }

        $req = $this->pdoMysqlQuery($query);

        while ($donnees = $req->fetch()){
            $users[] = $this->userCreator($donnees);
        }

        return $users;

	}


	/**
	 * @access public
	 * @param string $login 
	 * @param string $motDePasse 
	 * @return object Utilisateur
     *
     * Identifie un utilisateur avec son identifiant et son mot de passe, puis construit la session Utilisateur correspondante
	 */

	public function identifyUser($login, $motDePasse)
    {

        $user = $this->getUserByLogin($login, $motDePasse);

        $donnees = $user->fetch();


        if ((int)count($donnees) <= 1) {
            $_SESSION['message-erreur'] = 'Login incorrect';
        } else {

            $_SESSION['message-ok'] = 'Bienvenue ' . $donnees['nom'] . ' ' . $donnees['prenom'];

            $currentUser = $this->userCreator($donnees);


            if (method_exists($currentUser, 'getDroits')){
                // On défini les roles en fonction des droits
                if ($currentUser->getDroits() == 1){
                    $_SESSION['role'] = 'admin';
                } else if($currentUser->getDroits() == 2){
                    $_SESSION['role'] = 'service';
                } else if($currentUser->getDroits() == 3){
                    $_SESSION['role'] = 'livreur';
                }
            } else {
                $_SESSION['role'] = 'client';
            }


            return $currentUser;
        }

    }


	/**
	 * @access public
	 * @param Utilisateur
	 * @return void
     *
     * Ajoute un utilisateur en BDD selon le type d'objet reçu (client || employe || livreur)
	 */

	public  function addUser($utilisateur) {

	    // si il s'agit d'un client
	    if (method_exists($utilisateur, 'getNumero')){

            $query = "INSERT INTO client VALUES (NULL, ".$utilisateur->getNumero().", '".$utilisateur->getRue()."', ".$utilisateur->getCodePostal().", '".$utilisateur->getVille()."')";
            $this->pdoMysqlQuery($query);
            $query = "SELECT MAX(id_client) as id_client FROM client";
            $resultat = $this->pdoMysqlQuery($query);
            $donnees = $resultat->fetch();
            $query = "INSERT INTO utilisateur VALUES (NULL, '".$utilisateur->getNom()."', '".$utilisateur->getPrenom()."', '".$utilisateur->getMail()."', '".$utilisateur->getMotDePasse()."', NULL, ".$donnees['id_client'].", 1)";
            $this->pdoMysqlQuery($query);

        // si il s'agit d'un employe
        } else {

	        $idLivreur = NULL;

	        // Si il s'agit d'un livreur on commence par créer le livreur en BDD et enregistrer son identifiant
	        if(method_exists($utilisateur, 'dispo')){
	            $query = "INSERT INTO livreur VALUES (NULL, '".$utilisateur->getLocationLat()."', '".$utilisateur->getLocationLong()."', '".$utilisateur->getVilleRatach()."', 1)";
	            $this->pdoMysqlQuery($query);
                $query = "SELECT MAX(id_livreur) as id_livreur FROM livreur";
                $resultat = $this->pdoMysqlQuery($query);
                $donnees = $resultat->fetch();
                $idLivreur = $donnees['id_livreur'];
            }

            //On enregistre l'employe
            $query = "INSERT INTO employe VALUES (".$utilisateur->getDroits().", ".$idLivreur.")";
            $this->pdoMysqlQuery($query);
            $query = "SELECT MAX(id_employe) as id_employe FROM employe";
            $resultat = $this->pdoMysqlQuery($query);
            $donnees = $resultat->fetch();
            $query = "INSERT INTO utilisateur VALUES (NULL, '".$utilisateur->getNom()."', '".$utilisateur->getPrenom()."', '".$utilisateur->getMail()."', '".$utilisateur->getMotDePasse()."', ".$donnees['id_employe'].", NULL, 1)";
            $this->pdoMysqlQuery($query);

        }


	}


	/**
	 * @access public
	 * @param object $Utilisateur 
	 * @return void
     *
     * Met à jour un utilisateur
	 */

	public  function updateUser( $utilisateur) {

        $this->pdoMysqlQuery('START TRANSACTION');

        $query = "UPDATE utilisateur SET ";
        $query .= " nom='".$utilisateur->getNom();
        $query .= "', prenom='".$utilisateur->getPrenom();
        $query .= "', mail='".$utilisateur->getMail();
        $query .= "', mot_de_passe='".$utilisateur->getMotDePasse();
        $query .= "', visible=".$utilisateur->getVisible();
        $query .= " WHERE id_utilisateur=".$utilisateur->getIdUtilisateur();



        $this->pdoMysqlQuery($query);

        if (!method_exists($utilisateur, 'getDroits')){
            $query = "UPDATE client SET ";
            $query .= " numero=".$utilisateur->getNumero();
            $query .= ", rue='".$utilisateur->getRue();
            $query .= "', code_postal=".$utilisateur->getCodePostal();
            $query .= ", ville='".$utilisateur->getVille();
            $query .= "', WHERE id_client=".$utilisateur->getIdClient();

            $this->pdoMysqlQuery($query);

        } else if (method_exists($utilisateur, 'getDroits')){
            $query = "UPDATE employe SET ";
            $query .= " droits=".$utilisateur->getDroits();
            $query .= " WHERE id_employe=".$utilisateur->getIdEmploye();

            $this->pdoMysqlQuery($query);

            if ($utilisateur->getDroits() == "3"){

                $query = "UPDATE livreur SET ";
                $query .= " location_lat='".$utilisateur->getLocationLat();
                $query .= "', location_long='".$utilisateur->getLocationLong();
                $query .= "', ville_ratach='".$utilisateur->getVilleRatach();
                $query .= "', dispo=".$utilisateur->getDispo();
                $query .= " WHERE id_livreur=".$utilisateur->getLivreurId();


                $this->pdoMysqlQuery($query);

            }
        }

        $this->pdoMysqlQuery('COMMIT');
	}


    /**
     * @param $login
     * @param $motDePasse
     *
     * return PDO Object
     */
    public function getUserByLogin($login, $motDePasse){

        $query = "SELECT * FROM utilisateur";
        $query .= " ";
        $query .= "LEFT JOIN client ON utilisateur.client_id_client = client.id_client";
        $query .= " ";
        $query .= "LEFT JOIN employe ON utilisateur.employe_id_employe = employe.id_employe";
        $query .= " ";
        $query .= "LEFT JOIN livreur ON employe.livreur_id_livreur = livreur.id_livreur";
        $query .= " ";
        $query .= "WHERE mail ='" . $login . "'";
        $query .= " ";
        $query .= "AND mot_de_passe = '" . $motDePasse . "'";
        $query .= " ";
        $query .= "AND visible=1";
        $query .= " ";
        $query .= "LIMIT 1";

        return $this->pdoMysqlQuery($query);

    }

    /**
     *
     * @param $donnees => tableau de données PDO
     * @return Client|Employe|Livreur
     *
     */
    public function userCreator($donnees){

        if (isset($donnees['client_id_client'])) {

            //Si c'est un client, on instancie une entité client
            $curentUser = new Client($donnees['id_utilisateur'],$donnees['nom'], $donnees['prenom'], $donnees['mail'], $donnees['mot_de_passe'], NULL, $donnees['client_id_client'], 1, $donnees['numero'], $donnees['rue'], $donnees['code_postal'], $donnees['ville']);


        } else if (isset($donnees['employe_id_employe'])) {



            if(isset($donnees['livreur_id_livreur'])){

                // si c'est un  livreur on instancie une entité Livreur
                $curentUser = new Livreur($donnees['id_utilisateur'],$donnees['nom'], $donnees['prenom'], $donnees['mail'], $donnees['mot_de_passe'], $donnees['employe_id_employe'], NULL, 1, $donnees['droits'], $donnees['livreur_id_livreur'], $donnees['location_lat'], $donnees['location_long'], $donnees['ville_ratach'], $donnees['dispo']);


            } else {

                // sinon, on définit l'entité comme instance de employé
                $curentUser = new Employe($donnees['id_utilisateur'],$donnees['nom'], $donnees['prenom'], $donnees['mail'], $donnees['mot_de_passe'], $donnees['employe_id_employe'], NULL, 1, $donnees['droits'], NULL);

            }

        }
        return $curentUser;
    }

}
