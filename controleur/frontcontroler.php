<?php

/*
 * Partie Gérant l'affichage des tâche et des listes
 */


/*
 * Importer les pages nécessaire au bon fonctionnement du programme
 */
require_once('modeles/GatewayListe.php');
require_once('modeles/Connection.php');
require_once('modeles/GatewayTache.php');

$user = "dynotsouca";
$dsn = 'mysql:host=localhost;dbname=todolist;';
$password="1234";

class frontcontroler
{

    static function bonsoir ($i){
        global $user;
        global $dsn;
        global $password;
        // Dans le cas où nous souhaitons l'affichage des liste
        if($i == 1){
            //création d'un gatewayliste pour gérer les requetes touchant les listes
            $u = new GatewayListe(new Connection($dsn, $user, $password));

            //afficher la liste spécifique
            if(!isset($_SESSION['listenum'])) {
                $_SESSION['listenum'] = $u->getnblmin();
                // Récupérer nom de la liste
                $test = $u->FindByIdOne($_SESSION['listenum']);
                foreach ($test as $r){
                    $_SESSION['listename'] = $r->getNomDeListe();
                }
            }
            //dans le cas ou un utilisateur est connecté
            if(!empty($_SESSION["idUser"])){
                $idUtilisateur = $_SESSION["idUser"];
                $result = $u->findByIdUser($idUtilisateur);
                $u->afficherTbListe($result);
            }
            //afficher les liste publiques
            $result = $u->findByPublic(0);
            $u->afficherTbListe($result);
        }
        // Dans le cas où nous souhaitons l'affichage des taches
        if($i == 2){
            //création d'un gatewaytache pour gérer les requetes touchant les taches
            $u = new GatewayTache(new Connection($dsn, $user, $password));
            //fonction pour savoir le nb de taches dans la liste

            $result = $u->FindById($_SESSION['listenum']);
            $u->afficherTbTache($result);
        }

    }


}