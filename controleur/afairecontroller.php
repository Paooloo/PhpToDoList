<?php

require_once('../modeles/GatewayTache.php');
require_once('../modeles/Connection.php');

$user = "dynotsouca";
$dsn = 'mysql:host=localhost;dbname=todolist;';
$password="1234";


try {
    $u = new GatewayTache(new Connection($dsn, $user, $password));


    if(isset($_POST['action-task-todo'])){
        foreach ($_POST['task'] as $r){
            $result = $u->FindByNameOne($r);
            $f = $result->isFait();
            $p = $result->getIdTache();
            //si a faire
            if($f == 0){
                $u->changerfait($p);
            }
        }
    }
    if(isset($_POST['action-task-done'])){
        foreach ($_POST['task'] as $r){
            $result = $u->FindByNameOne($r);
            $f = $result->isFait();
            $p = $result->getIdTache();
            //si fait
            if($f == 1){
                $u->changerAfaire($p);
            }
        }
    }
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