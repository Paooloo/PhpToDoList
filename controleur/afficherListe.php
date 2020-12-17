<?php

require_once('modeles/GatewayListe.php');
require_once('modeles/Connection.php');

$user = "dynotsouca";
$dsn = 'mysql:host=localhost;dbname=todolist;';
$password="1234";
//trouver la valeur la plus petite pour afficher la premiere liste

try {
    $u = new GatewayListe(new Connection($dsn, $user, $password));



    if(!isset($_SESSION['listenum'])) {
        $_SESSION['listenum'] = $u->getnblmin();
        // Récupérer nom de la liste
        $test = $u->FindByIdOne($_SESSION['listenum']);
        foreach ($test as $r){
            $_SESSION['listename'] = $r->getNomDeListe();
        }
    }

    if(!empty($_SESSION["idUser"])){
        $idUtilisateur = $_SESSION["idUser"];
        $result = $u->findByIdUser($idUtilisateur);
        $u->afficherTbListe($result);
    }
    //affciher listepublique
    $result = $u->findByPublic(0);
    $u->afficherTbListe($result);

}catch (PDOException $e){
    $erreur = $e -> getMessage();
    $_SESSION['erreur'] = $erreur;
    header( 'Location: ../vues/erreur.php?var1='.$_SESSION['erreur']);
}