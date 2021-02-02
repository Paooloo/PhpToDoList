<?php
/*
 * Controleur permettant de gérer la suppression, trouver et ajouter une liste
 */

/*
 * Importer les pages nécessaire au bon fonctionnement du programme
 */
require_once('../modeles/GatewayListe.php');
require_once('../modeles/Liste.php');
require_once('../modeles/Connection.php');

session_start();

/*
 * Informations personnelles de connection à la BDD
 */
$user = "dynotsouca";
$dsn = 'mysql:host=localhost;dbname=todolist;';
$password="1234";

/*
 * Informations sur la liste => De  base initialisé en public
 */
$Publie = 0;
$etat = 0;
$idUtilisateur = 0;

//création d'un gatewayliste pour gérer les requetes touchant les listes
$u = new GatewayListe(new Connection($dsn, $user, $password));

/*
 * Si un utilisateur est connecté, change l'etat en privé et l'iduser pour la création de liste
 */
if($_SESSION["idUser"] != NULL){
    $idUtilisateur = $_SESSION["idUser"];
    $etat = 1;
}

/*
 * Méthode pour supprimer une liste
 * -> récupérer le numéro de la liste
 * -> supprimer toutes les taches contenu dans cette liste
 * -> supprimer la liste
 * -> Récupérer la liste la plus ancienne crée de façon à l'afficher
 * -> Afficher cette liste récupérée
 *
 * Erreur :
 * -> Si l'on souhaite supprimer la dernière liste publique
 */
if(isset($_POST['suppressionListe'])){
    try {
        //suppression quand il y a plus d'une liste public
        //suppression quand >1 public et liste est privé
        if ($u->getnbltotal() > 1 && $u->getnbltotalpriv($idUtilisateur) > 0 || $u->getnbltotalpub($idUtilisateur) > 0) {
            $num = $u->FindByNameOne($_SESSION['listename']);
            foreach ($num as $r) {
                $numList = $r->getIdListe();
            }
            $u->SupprimerTTeLesTaches($numList);
            $u->SupprimerList($numList);
            $_SESSION['listenum'] = $u->getnblmin();
            $test = $u->FindByIdOne($_SESSION['listenum']);
            foreach ($test as $r) {
                $_SESSION['listename'] = $r->getNomDeListe();
            }
        } else{
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
/*
 * Méthode pour Afficher une liste
 * -> Récupérer la liste
 * -> Mettre à jour les variables locales
 */
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

/*
 * Méthode pour ajouter une liste
 * -> récupérer le nom de la liste
 * -> incrémenter le numéro de liste (+1 du max)
 * -> création de la liste
 * -> insertion de la liste
 * -> Afficher cette liste
 *
 * Erreur :
 * -> Si l'on souhaite ajouter une liste sans nom
 */
if(isset($_POST['addList'])){

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
