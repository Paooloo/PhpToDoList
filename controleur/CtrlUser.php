<?php
session_start();

require_once('../modeles/GatewayUtilisateur.php');
require_once('../modeles/Connection.php');
require_once('../modeles/Utilisateur.php');

$conEmail = $_POST['conemail'];
$conPassword = $_POST['conpassword'];


$user = "dynotsouca";
$dsn = 'mysql:host=localhost;dbname=todolist;';
$password="1234";

$conPassword = filter_var($conPassword, FILTER_SANITIZE_STRING);

if (filter_var($conEmail, FILTER_VALIDATE_EMAIL)){
    $bool1=0;
} else {
    $bool1 = -1;
}

if($bool1<0){
    header('location: ../erreur.php');
}

try {
    $u = new GatewayUtilisateur(new Connection($dsn, $user, $password));

    $result= $u->FindByEmail($conEmail);
    foreach ($result as $r){
        if($conPassword == $r->get_Password())
        {
            $_SESSION['pseudo'] = $r->get_prenom();
            $_SESSION['idUser'] = $r->get_IDpersonne();
            header('location: ../index.php');
        }else{
            $erreur ='Mot de passe incorrect';
            $_SESSION['erreur'] = $erreur;
            header('Location: ../vues/erreur.php?var1=' . $_SESSION['erreur']);
        }
    }
}catch (PDOException $e) {
    $erreur = $e->getMessage();
    $_SESSION['erreur'] = $erreur;
    header('Location: ../vues/erreur.php?var1=' . $_SESSION['erreur']);
}