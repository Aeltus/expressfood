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
    $query = "SELECT * FROM livreur WHERE ville_ratach='".$client->getVille()."' AND dispo=1";
    $livreurs = $this->pdoMysqlQuery($query);
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


    // on cherche le plus proche
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

        $_SESSION['message-ok'] = "Merci de votre commande<br />L'id du livreur choisi est : ".$idLivreurChoisi." il se trouve actuellement à ".$distance." et sera chez vous d'ici ".$dureStr;
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
	 * @return object
     *
     * trouve un livreur en BDD
	 */

	public  function getLivreurById($idLivreur) {

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

        $user = $this->pdoMysqlQuery($query);

        $donnees = $user->fetch();


        if ((int)count($donnees) <= 1) {
            $_SESSION['message-erreur'] = 'Login incorrect';
        } else {

            $_SESSION['message-ok'] = 'Bienvenue ' . $donnees['nom'] . ' ' . $donnees['prenom'];

            if (isset($donnees['client_id_client'])) {

                $client = new Client();
                $client->setIdUtilisateur($donnees['id_utilisateur']);
                $client->setNom($donnees['nom']);
                $client->setPrenom($donnees['prenom']);
                $client->setMail($donnees['mail']);
                $client->setIdClient($donnees['client_id_client']);
                $client->setNumero($donnees['numero']);
                $client->setRue($donnees['rue']);
                $client->setCodePostal($donnees['code_postal']);
                $client->setVille($donnees['ville']);

                $_SESSION['role'] = 'client';

                return $client;

            } else if (isset($donnees['employe_id_employe'])) {



                if(isset($donnees['livreur_id_livreur'])){

                    // si c'est un  livreur on commence par définir les attributs spécifiques
                    $employe = new Livreur();
                    $employe->setLocationLat($donnees['location_lat']);
                    $employe->setLocationLong($donnees['location_long']);
                    $employe->setVilleRatach($donnees['ville_ratach']);



                } else {

                    // sinon, on définit l'entité comme instance de employé
                    $employe = new Employe();

                }

                //on définit les attributs communs à employé et livreur
                $employe->setIdUtilisateur($donnees['id_utilisateur']);
                $employe->setNom($donnees['nom']);
                $employe->setPrenom($donnees['prenom']);
                $employe->setMail($donnees['mail']);
                $employe->setIdEmploye($donnees['employe_id_employe']);
                $employe->setDroits($donnees['droits']);


                if ($employe->getDroits() == 1){
                    $_SESSION['role'] = 'admin';
                } else if($employe->getDroits() == 2){
                    $_SESSION['role'] = 'service';
                } else if($employe->getDroits() == 3){
                    $_SESSION['role'] = 'livreur';
                }

                return $employe;

            }

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

	public final  function updateUser( $Utilisateur) {

	}


}
?>