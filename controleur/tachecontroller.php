<?php

require_once('../modeles/GatewayTache.php');
require_once('../modeles/Tache.php');
require_once('../modeles/Connection.php');
session_start();
$recupnom = $_POST['nomtache'];
$faire = 1;

$user = "dynotsouca";
$dsn = 'mysql:host=localhost;dbname=todolist;';
$password="1234";

$afaire = filter_var($faire, FILTER_VALIDATE_BOOLEAN);
$recupnom = filter_var($recupnom, FILTER_SANITIZE_STRING);

try {
    // erreur
    if($recupnom == ""){
        throw new Exception('Variable Null: une variable ne peut pas être null');
    }

    $u = new GatewayTache(new Connection($dsn, $user, $password));
    $id = ($u)->getnbt()+1;
    $idliste = $_SESSION['listenum'];
    $tache = new Tache($id, $recupnom, $afaire,$idliste);
    $u->insert($tache);
    header( 'Location: ../index.php');

}catch (Exception $e){
    $erreur = $e -> getMessage();
    $_SESSION['erreur'] = $erreur;
    header( 'Location: ../vues/erreur.php?var1='.$_SESSION['erreur']);
}