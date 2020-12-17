<?php
session_start();

require_once('../modeles/GatewayUtilisateur.php');
require_once('../modeles/Utilisateur.php');
require_once('../modeles/Connection.php');



$recupNom = $_POST['nom'];
$recupPrenom = $_POST['prenom'];
$recupNaissance = $_POST['naissance'];
$recupEmail = $_POST['email'];
$recupPassword = $_POST['password'];


$user = "dynotsouca";
$dsn = 'mysql:host=localhost;dbname=todolist;';
$password="1234";

if (filter_var($recupEmail, FILTER_VALIDATE_EMAIL)){
    $bool=0;
} else {
    $bool=-1;
}


$recupNom = filter_var($recupNom, FILTER_SANITIZE_STRING);
$recupPrenom = filter_var($recupPrenom, FILTER_SANITIZE_STRING);

if($bool<0){
    header('location: ../erreur.php');
}

try {
    $u = new GatewayUtilisateur(new Connection($dsn, $user, $password));
    $idUser= ($u)->getnbu()+1;

    $_SESSION['pseudo'] = $recupPrenom;
    $_SESSION['idUser'] = $idUser;

    $Utilisateur1 = new Utilisateur($idUser, $recupNom, $recupPrenom, $recupEmail, $recupPassword);
    $u->insert($Utilisateur1);
    header('location: ../index.php');



}catch (PDOException $e){
    $erreur = $e->getMessage();
    $_SESSION['erreur'] = $erreur;
    header('Location: ../vues/erreur.php?var1=' . $_SESSION['erreur']);
}

