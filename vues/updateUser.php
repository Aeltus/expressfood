<div class="row">
     <div class="col-md-12 text-center">

<?php
/**
 * Created by PhpStorm.
 * User: Davis
 * Date: 13/12/2016
 * Time: 19:05
 */


/* Récuptération de l'entité Utilisateur
======================================================================================================================*/
$req = new UserManager();
$utilisateur = $req->getUtilisateurById($_GET['id']);

/*====================================================================================================================*/

/*Création du formulaire adapté au type d'utilisateur
======================================================================================================================*/

//partie commune
?>

<form  method="post" action="index.php?content=userUpdate&id=<?php echo $utilisateur->getIdUtilisateur(); ?>">

<span><h3>Informations de contact</h3></span>
<br />
<label for="nom">Nom : </label><input type="text" value="<?php echo $utilisateur->getNom(); ?>" name="nom" id="nom" required>
<label for="prenom">Prenom : </label><input type="text" value="<?php echo $utilisateur->getPrenom(); ?>" name="prenom" id="prenom" required><br />
<label for="mail">Mail : </label><input size=30 type="text" value="<?php echo $utilisateur->getMail(); ?>" name="mail" id="mail" required><br />


<?php
// Si c'est un Client
if (method_exists($utilisateur, 'getNumero')){
    ?>
    <hr>
    <h3>Adresse :</h3>
    <br />
    <label for="numero">Numero : </label><input type="text" value="<?php echo $utilisateur->getNumero(); ?>" name="numero" id="numero" required>
    <label for="rue">Rue : </label><input type="text" value="<?php echo $utilisateur->getRue(); ?>" name="rue" id="rue" required><br />
    <label for="codePostal">Code postal : </label><input type="text" value="<?php echo $utilisateur->getCodePostal(); ?>" name="codePostal" id="codePostal" required>
    <label for="ville">Ville : </label><input type="text" value="<?php echo $utilisateur->getVille(); ?>" name="ville" id="ville" required><br />

    <?php
// Sinon, c'est un employe
} else {
    ?>
    <label for="droits">Droits : </label>
    <select name="droits" id="droits" required>
        <option value="3" <?php if($utilisateur->getDroits() == '3')   echo 'selected"'; ?> >Livreur</option>
        <option value="2" <?php if($utilisateur->getDroits() == '2')   echo 'selected"'; ?>>Service client</option>
        <option value="1" <?php if($utilisateur->getDroits() == '1')   echo 'selected"'; ?>>Administrateur</option>
    </select>

<?php
    // Si c'est un livreur
    if (method_exists($utilisateur, 'getdispo')) {

        ?>

    <label for="locationLat" > Position latitude : </label ><input type = "text" value = "<?php echo $utilisateur->getLocationLat(); ?>" name = "locationLat" id = "locationLat" required >
    <label for="locationLong" > Position longitude : </label ><input type = "text" value = "<?php echo $utilisateur->getLocationLong(); ?>" name = "locationLong" id = "locationLong" required ><br />
    <label for="villeRatach" > Ville de ratachement : </label ><input type = "text" value = "<?php echo $utilisateur->getVilleRatach(); ?>" name = "villeRatach" id = "villeRatach" required >
    <label for="dispo">Disponible (cocher pou oui)</label><input type="checkbox" name="dispo" id="dispo"><br />
<?php

    }
}

?>

    <input type="submit" value="Valider">

</form>

<!--=================================================================================================================-->

    </div>
</div>