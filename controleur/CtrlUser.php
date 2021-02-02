<?php
session_start();

/*
 *Controleur pour la deconnexion, la connection et l'inscription des utilisateurs
 */



/*
 * Importer les pages nécessaire au bon fonctionnement du programme
 */
require_once('../modeles/GatewayUtilisateur.php');
require_once('../modeles/Connection.php');
require_once('../modeles/Utilisateur.php');

$user = "dynotsouca";
$dsn = 'mysql:host=localhost;dbname=todolist;';
$password="1234";



//Parti gérant la déconnexion
if(isset($_POST['deconnexion'])){
    try{
        //Détruit la session actuel
        session_destroy();
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

//Parti gérant la connexion
if(isset($_POST['connexion'])){

    $conEmail = $_POST['conemail'];
    $conPassword = $_POST['conpassword'];

    //Filtre le mot de passe
    $conPassword = filter_var($conPassword, FILTER_SANITIZE_STRING);

    //Filtre l'email
    if (filter_var($conEmail, FILTER_VALIDATE_EMAIL)){
        $bool1=0;
    } else {
        $bool1 = -1;
    }

    if($bool1<0){
        header('location: ../erreur.php');
    }

    try {
        //Connection à la base de données via la gateway utilisateur
        $u = new GatewayUtilisateur(new Connection($dsn, $user, $password));

        //Recherche dans la base de données l'email
        $result= $u->FindByEmail($conEmail);

        //Pour tous les résultats obtenu de la recherche
        foreach ($result as $r){
            //Test du mot de passe
            if($conPassword == $r->get_Password())
            {
                $_SESSION['pseudo'] = $r->get_prenom();
                $_SESSION['idUser'] = $r->get_IDpersonne();
                header('location: ../index.php');
            }else{
                //Sinon message erreur
                $erreur ='Mot de passe incorrect';
                $_SESSION['erreur'] = $erreur;
                header('Location: ../vues/erreur.php?var1=' . $_SESSION['erreur']);
            }
        }

    }catch (PDOException $e){
        //Exception lié a la base de données
        $erreur = $e -> getMessage();
        $_SESSION['erreur'] = $erreur;
        header( 'Location: ../vues/erreur.php?var1='.$_SESSION['erreur']);
    }catch (Exception $ee){
        //Autres Exceptions
        $erreur = $ee -> getMessage();
        $_SESSION['erreur'] = $erreur;
        header( 'Location: ../vues/erreur.php?var1='.$_SESSION['erreur']);
    }
}

//Parti gérant l'insciption
if(isset($_POST['inscription'])){
    $recupNom = $_POST['nom'];
    $recupPrenom = $_POST['prenom'];
    $recupNaissance = $_POST['naissance'];
    $recupEmail = $_POST['email'];
    $recupPassword = $_POST['password'];


    //Filtre l'email
    if (filter_var($recupEmail, FILTER_VALIDATE_EMAIL)){
        $bool=0;
    } else {
        $bool=-1;
    }
    if($bool<0){
        header('location: ../erreur.php');
    }

    //Filtre de la date de naissance
    $recupNaissance = filter_var($recupNaissance, FILTER_SANITIZE_STRING);
    //Filtre du mot de passe
    $recupPassword = filter_var($recupPassword, FILTER_SANITIZE_STRING);
    //Filtre du nom
    $recupNom = filter_var($recupNom, FILTER_SANITIZE_STRING);
    //Filtre du prenom
    $recupPrenom = filter_var($recupPrenom, FILTER_SANITIZE_STRING);



    try {

        $u = new GatewayUtilisateur(new Connection($dsn, $user, $password));
        //Créer une nouvelle id pour l'utilisateur
        $idUser= ($u)->getnbu()+1;

        //Initialise les session pseudo et idUser
        $_SESSION['pseudo'] = $recupPrenom;
        $_SESSION['idUser'] = $idUser;

        //Ajoute un nouvel utilisateur
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
