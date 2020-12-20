<?php
session_start();

require_once('../modeles/GatewayUtilisateur.php');
require_once('../modeles/Connection.php');
require_once('../modeles/Utilisateur.php');

$user = "dynotsouca";
$dsn = 'mysql:host=localhost;dbname=todolist;';
$password="1234";

if(isset($_POST['deconnexion'])){
    try{
        session_destroy();
        //$_SESSION = array();
        header('Location: ../index.php');
    }catch (PDOException $e){
        $erreur = $e -> getMessage();
        $_SESSION['erreur'] = $erreur;
        header( 'Location: ../vues/erreur.php?var1='.$_SESSION['erreur']);
    }catch (Exception $ee){
        $erreur = $ee -> getMessage();
        $_SESSION['erreur'] = $erreur;
        header( 'Location: ../vues/erreur.php?var1='.$_SESSION['erreur']);
    }
}

if(isset($_POST['connexion'])){
    $conEmail = $_POST['conemail'];
    $conPassword = $_POST['conpassword'];
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
    }catch (PDOException $e){
        $erreur = $e -> getMessage();
        $_SESSION['erreur'] = $erreur;
        header( 'Location: ../vues/erreur.php?var1='.$_SESSION['erreur']);
    }catch (Exception $ee){
        $erreur = $ee -> getMessage();
        $_SESSION['erreur'] = $erreur;
        header( 'Location: ../vues/erreur.php?var1='.$_SESSION['erreur']);
    }
}


if(isset($_POST['inscription'])){
    $recupNom = $_POST['nom'];
    $recupPrenom = $_POST['prenom'];
    $recupNaissance = $_POST['naissance'];
    $recupEmail = $_POST['email'];
    $recupPassword = $_POST['password'];


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
        $erreur = $e -> getMessage();
        $_SESSION['erreur'] = $erreur;
        header( 'Location: ../vues/erreur.php?var1='.$_SESSION['erreur']);
    }catch (Exception $ee){
        $erreur = $ee -> getMessage();
        $_SESSION['erreur'] = $erreur;
        header( 'Location: ../vues/erreur.php?var1='.$_SESSION['erreur']);
    }

}
