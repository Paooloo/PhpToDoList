<?php
/*
 * Controleur permettant de gérer les tâches
 */
/*
 * Importer les pages nécessaire au bon fonctionnement du programme
 */
require_once('../modeles/GatewayTache.php');
require_once('../modeles/Tache.php');
require_once('../modeles/Connection.php');

session_start();

/*
 * Informations personnelles de connection à la BDD
 */
$user = "dynotsouca";
$dsn = 'mysql:host=localhost;dbname=todolist;';
$password="1234";

//création d'un gatewaytache pour gérer les requetes touchant les listes
$u = new GatewayTache(new Connection($dsn, $user, $password));

/*
 * Méthode pour ajouter une tache
 * -> Marquer la tache a faire et récupérer le nom marqué par l'user
 * -> Vérifier que le nom n'est pas vide
 * -> incrémentation pour l'id (max +1)
 * -> créer la liste
 * -> insérer la liste
 *
 * Erreur :
 * -> Si le nom est null
 */
if(isset($_POST['action-task-add'])){
    $faire = 1;
    $afaire = filter_var($faire, FILTER_VALIDATE_BOOLEAN);
    try {
        $recupnom = $_POST['nomtache'];
        $lenom = filter_var($recupnom, FILTER_SANITIZE_STRING);
        // erreur
        if($lenom == ""){
            throw new PDOException('Variable Null: une variable ne peut pas être null');
        }
        $id = ($u)->getnbt()+1;
        $idliste = $_SESSION['listenum'];
        $tache = new Tache($id, $recupnom, $afaire,$idliste);
        $u->insert($tache);

        header( 'Location: ../index.php');
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

/*
 * Méthode pour marquer une tache faite
 * -> Récupérer la tache
 * -> Mettre à jour la tache -> marqué faite
 */
if(isset($_POST['action-task-done'])){
    try{
        foreach ($_POST['task'] as $r){
            $result = $u->FindByNameOne($r);
            $f = $result->isFait();
            $p = $result->getIdTache();
            //si a faire
            if($f == 0){
                $u->changerfait($p);
            }
        }

        header( 'Location: ../index.php');
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

/*
 * Méthode pour marquer une tache a faire
 * -> Récupérer la tache
 * -> Mettre à jour la tache -> marqué a faire
 */
if(isset($_POST['action-task-todo'])){
    try{
        foreach ($_POST['task'] as $r){
            $result = $u->FindByNameOne($r);
            $f = $result->isFait();
            $p = $result->getIdTache();
            //si fait
            if($f == 1){
                $u->changerAfaire($p);
            }
        }

        header( 'Location: ../index.php');
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

/*
 * Méthode pour suprimer une tache
 * -> Récupérer la/les tache/s
 * -> Supprimer la/les tache/s
 */
if(isset($_POST['action-task-delete'])){
    try{
        if(isset($_POST['action-task-delete'])){
            foreach ($_POST['task'] as $r){
                $result = $u->FindByNameOne($r);
                $f = $result->isFait();
                $p = $result->getIdTache();
                $u->supprimertache($p);

            }
        }

        header( 'Location: ../index.php');
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

