<?php

require_once('../modeles/GatewayTache.php');
require_once('../modeles/Tache.php');
require_once('../modeles/Connection.php');
session_start();
$user = "dynotsouca";
$dsn = 'mysql:host=localhost;dbname=todolist;';
$password="1234";
$u = new GatewayTache(new Connection($dsn, $user, $password));

if(isset($_POST['action-task-add'])){
    $recupnom = $_POST['nomtache'];
    $faire = 1;

    $afaire = filter_var($faire, FILTER_VALIDATE_BOOLEAN);
    $recupnom = filter_var($recupnom, FILTER_SANITIZE_STRING);
    try {
        // erreur
        if($recupnom == ""){
            throw new Exception('Variable Null: une variable ne peut pas être null');
        }

        $id = ($u)->getnbt()+1;
        $idliste = $_SESSION['listenum'];
        $tache = new Tache($id, $recupnom, $afaire,$idliste);
        $u->insert($tache);
    }catch (Exception $e){
        $erreur = $e -> getMessage();
        $_SESSION['erreur'] = $erreur;
        header( 'Location: ../vues/erreur.php?var1='.$_SESSION['erreur']);
    }
}

if(isset($_POST['action-task-todo'])){
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


if(isset($_POST['action-task-done'])){
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

header( 'Location: ../index.php');
