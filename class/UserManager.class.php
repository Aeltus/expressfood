<?php
/**
 *
 * @see        DAO
 */

class UserManager extends DAO {


	/**
	 * @access public
	 * @param object $client
	 * @return array
     *
     * recherche les livreurs disponibles dans la ville et
     * connection à l'API de GOOGLE MAPS pour trouver dans la ville,  le livreur le plus proche du point de livraison
	 */

	public function trouveLivreur($client) {
    /* Cette méthode utilise l' API de GOOGLE Maps pour trouver dans la ville,  le livreur le plus proche du point de livraison
    =============================================================================================================================*/

    //infos client
    $adresseClient = $client->getNumero().' '.$client->getRue().' '.$client->getCodePostal().' '.$client->getVille();
    $adresseClient = str_replace(" ", "+", $adresseClient);


    // recup infos livreurs en BDD
    $livreurs = $this->getLivreursByVille($client->getVille());
    $nbrePostulants = 0;
    $idLivreurs = [];

    while($livreur = $livreurs->fetch()){

        if (!isset($coordonnees)){
            $coordonnees = "";
        } else {
            $coordonnees .= "|";
        }
        $coordonnees .= $livreur['location_lat'].','.$livreur['location_long'];
        $idLivreurs += array($nbrePostulants => $livreur['id_livreur']);
        $nbrePostulants++;
    }

    //envoi requette API GOOGLE
    $contenu_du_fichier = file_get_contents("https://maps.googleapis.com/maps/api/distancematrix/json?origins=".$adresseClient."&destinations=".$coordonnees."&language=fr-FR&key=AIzaSyCFJqwu_dF21beyYKk6c_33MnvvXK3wvGs");
    $json = json_decode ($contenu_du_fichier);


    // on cherche le plus proche à moins de 20 min
    $duree = 1200; //20 min en sec
    $rangLivreurChoisi = -1; // initialise à -1 pour vérifier l'affectation d'un livreur
    $idLivreurChoisi = -1;
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

        $idLivreurChoisi = $idLivreurs[$rangLivreurChoisi];
    }

    $infosLivraison = [];
    $infosLivraison += array("livreur" => $idLivreurChoisi);
    $infosLivraison += array("duree" => $dureStr);
    $infosLivraison += array("distance" => $distance);






    return $infosLivraison;
    /*===========================================================================================================================*/
	}


	/**
	 * @access public
	 * @param int $idLivreur 
	 * @return object Livreur
     *
	 */

	public  function getLivreurById($idLivreur) {

        $query = "SELECT * FROM utilisateur";
        $query .= " ";
        $query .= "LEFT JOIN employe ON utilisateur.employe_id_employe = employe.id_employe";
        $query .= " ";
        $query .= "LEFT JOIN livreur ON employe.livreur_id_livreur = livreur.id_livreur";
        $query .= " ";
        $query .= "WHERE id_livreur ='" . $idLivreur . "'";
        $query .= " ";
        $query .= "LIMIT 1";

        $livreur = $this->pdoMysqlQuery($query);
        $donnees = $livreur->fetch();

        return new Livreur($donnees['id_utilisateur'],$donnees['nom'], $donnees['prenom'], $donnees['mail'], $donnees['mot_de_passe'], $donnees['employe_id_employe'], $donnees['client_id_client'], 1, $donnees['droits'], $donnees['livreur_id_livreur'], $donnees['location_lat'], $donnees['location_long'], $donnees['ville_ratach'], $donnees['dispo']);

	}

    /**
     * @param $ville
     * @return PDOStatement
     */
    public function getLivreursByVille($ville){
        $query = "SELECT * FROM livreur WHERE ville_ratach='".$ville."' AND dispo=1";
        return $this->pdoMysqlQuery($query);
    }


	/**
	 * @access public
	 * @return object[array]
     *
     * Récupère en BDD une liste des utlisateurs
	 */

	public  function getUsers() {

	}


	/**
	 * @access public
	 * @param string $login 
	 * @param string $motDePasse 
	 * @return object
     *
     * Identifie un tulisateur avec son identifiant et son mot de passe, puis construit la session Utilisateur correspondante
	 */

	public function identifyUser($login, $motDePasse)
    {

        $user = $this->getUserByLogin($login, $motDePasse);

        $donnees = $user->fetch();


        if ((int)count($donnees) <= 1) {
            $_SESSION['message-erreur'] = 'Login incorrect';
        } else {

            $_SESSION['message-ok'] = 'Bienvenue ' . $donnees['nom'] . ' ' . $donnees['prenom'];

            if (isset($donnees['client_id_client'])) {

                //Si c'est un client, on instancie une entité client
                $curentUser = new Client($donnees['id_utilisateur'],$donnees['nom'], $donnees['prenom'], $donnees['mail'], $donnees['mot_de_passe'], NULL, $donnees['client_id_client'], 1, $donnees['numero'], $donnees['rue'], $donnees['code_postal'], $donnees['ville']);
                $_SESSION['role'] = 'client';


            } else if (isset($donnees['employe_id_employe'])) {



                if(isset($donnees['livreur_id_livreur'])){

                    // si c'est un  livreur on instancie une entité Livreur
                    $curentUser = new Livreur($donnees['id_utilisateur'],$donnees['nom'], $donnees['prenom'], $donnees['mail'], $donnees['mot_de_passe'], $donnees['employe_id_employe'], NULL, 1, $donnees['droits'], $donnees['livreur_id_livreur'], $donnees['location_lat'], $donnees['location_long'], $donnees['ville_ratach'], $donnees['dispo']);


                } else {

                    // sinon, on définit l'entité comme instance de employé
                    $curentUser = new Employe($donnees['id_utilisateur'],$donnees['nom'], $donnees['prenom'], $donnees['mail'], $donnees['mot_de_passe'], $donnees['employe_id_employe'], NULL, 1, $donnees['droits'], NULL);

                }

                // On défini les roles en fonction des droits
                if ($curentUser->getDroits() == 1){
                    $_SESSION['role'] = 'admin';
                } else if($curentUser->getDroits() == 2){
                    $_SESSION['role'] = 'service';
                } else if($curentUser->getDroits() == 3){
                    $_SESSION['role'] = 'livreur';
                }


            }
            return $curentUser;
        }

    }


	/**
	 * @access public
	 * @param int $idUtilisateur 
	 * @return void
     *
     * Ajoute un utilisateur en BDD
	 */

	public  function addUser($idUtilisateur) {

	}


	/**
	 * @access public
	 * @param int $idUtilisateur 
	 * @return void
     *
     * Efface un utilisateur de la BDD (rend invisible)
	 */

	public final  function deleteUser($idUtilisateur) {

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

            if ($utilisateur->getDroits() == 3){
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
        $query .= "WHERE mail ='" . $login . "'";
        $query .= " ";
        $query .= "AND mot_de_passe = '" . $motDePasse . "'";
        $query .= " ";
        $query .= "LIMIT 1";

        return $this->pdoMysqlQuery($query);

    }



}
?>