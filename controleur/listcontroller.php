<?php

require_once('../modeles/GatewayListe.php');
require_once('../modeles/Liste.php');
require_once('../modeles/Connection.php');
session_start();
$user = "dynotsouca";
$dsn = 'mysql:host=localhost;dbname=todolist;';
$password="1234";



$Publie = 0;
$etat = 0;
$idUtilisateur = 0;

$u = new GatewayListe(new Connection($dsn, $user, $password));


if($_SESSION["idUser"] != NULL){
    $idUtilisateur = $_SESSION["idUser"];
    $etat = 1;
}

//Méthode pour supprimer les tâches d'une liste, puis sa liste
if(isset($_POST['suppressionListe'])){
    //echo $u->getnbltotal();
    try {
        if ($u->getnbltotal() > 1) {
            $num = $u->FindByNameOne($_SESSION['listename']);
            //récupérer le numéro
            foreach ($num as $r) {
                $numList = $r->getIdListe();
            }
            //supprimer toutes les taches
            $u->SupprimerTTeLesTaches($numList);
            //supprimer la liste
            $u->SupprimerList($numList);
            //afficherp page
            $_SESSION['listenum'] = $u->getnblmin();
            // Récupérer nom de la liste
            $test = $u->FindByIdOne($_SESSION['listenum']);
            foreach ($test as $r) {
                $_SESSION['listename'] = $r->getNomDeListe();
            }
        } else {
            throw new Exception("Il doit y avoir une liste publique");
        }
        header('Location: ../index.php');
    }
        catch (PDOException $e) {
            $erreur = $e->getMessage();
            $_SESSION['erreur'] = $erreur;
            header('Location: ../vues/erreur.php?var1=' . $_SESSION['erreur']);
        } catch (Exception $ee) {
            $erreur = $ee->getMessage();
            $_SESSION['erreur'] = $erreur;
            header('Location: ../vues/erreur.php?var1=' . $_SESSION['erreur']);
        }
}

if(isset($_POST['laliste'])) {
    try {

        $num = $u->FindByNameOne($_POST['laliste']);
        foreach ($num as $r) {
            $_SESSION['listenum'] = $r->getIdListe();
            $_SESSION['listename'] = $r->getNomDeListe();
            header('Location: ../index.php?l=' . $_SESSION['listenum'] . 'n=' . $_SESSION['listename']);
        }

    } catch (PDOException $e) {
        $erreur = $e->getMessage();
        $_SESSION['erreur'] = $erreur;
        header('Location: ../vues/erreur.php?var1=' . $_SESSION['erreur']);
    } catch (Exception $ee) {
        $erreur = $ee->getMessage();
        $_SESSION['erreur'] = $erreur;
        header('Location: ../vues/erreur.php?var1=' . $_SESSION['erreur']);
    }
}

if(isset($_POST['addList'])){//suppression de liste

    try {

        $recupnom = $_POST['nomliste'];
        $lenom = filter_var($recupnom, FILTER_SANITIZE_STRING);
        if($recupnom == ""){
            throw new PDOException('Variable Null: une variapeble ne ut pas être null');
        }
        $id = ($u)->getnbl()+1;
        echo $id;
        $liste = new Liste($id, $lenom, $etat,$idUtilisateur);
        $u->insert($liste);
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