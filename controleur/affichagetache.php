<?php

require_once('modeles/GatewayTache.php');
require_once('modeles/Connection.php');

$user = "dynotsouca";
$dsn = 'mysql:host=localhost;dbname=todolist;';
$password="1234";


try {
    $u = new GatewayTache(new Connection($dsn, $user, $password));
    //fonction pour savoir le nb de taches dans la liste

    $result = $u->FindById($_SESSION['listenum']);
    $u->afficherTbTache($result);







}catch (Exception $e){
    $erreur = $e -> getMessage();
    $_SESSION['erreur'] = $erreur;
    header( 'Location: ../vues/erreur.php?var1='.$_SESSION['erreur']);
}