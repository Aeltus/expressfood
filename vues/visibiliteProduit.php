<?php
/**
 * Created by PhpStorm.
 * User: Davis
 * Date: 14/12/2016
 * Time: 18:29
 */

$req = new ProductManager();

$req->updateProduct($_GET['id'], $_GET['visible']);

$_SESSION['message-ok'] = "Mise à jour effectuée";

ServiceProvider::newPage(ServiceProvider::setRoute('gestionProduits'));
