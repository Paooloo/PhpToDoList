<?php

/*
 * Classe Gateway (protection) de la liste
 */

require_once('Connection.php');
require_once('Liste.php');

class GatewayListe
{
    /*
     * Constructeur qui nécessite une connection
     */
    function __construct(Connection $con){
        $this->con = $con;
    }

    /*
     * Fonction pour insérer une liste
     */
    public function insert(Liste $t): int {
        $query = 'INSERT INTO liste VALUES(:IdListe,:NomDeListe,:EstPublic,:IdPersonne)';
        $this->con->executeQuery($query, array(
            ':IdListe' => array($t->getIdListe(),PDO::PARAM_INT),
            ':NomDeListe' => array($t->getNomDeListe(),PDO::PARAM_STR),
            ':EstPublic' => array($t->isPublic(),PDO::PARAM_BOOL),
            ':IdPersonne' => array($t->getIdPersonne(),PDO::PARAM_INT)));
        return $this->con->lastInsertId();
    }

    /*
     * Recherche l'id minimum de la base de données des listes
     */
    public function getnblmin() :int {
        $this->con->executeQuery("SELECT MIN(IdListe) FROM liste WHERE Public=0");
        return intval($this->con->getResults()[0]['MIN(IdListe)']);
    }

    /*
<<<<<<< HEAD
     * Retourne le nombre total des id public
=======
     * Retourne le nombre total des id
>>>>>>> 2443aa30694e467989ad4dd0dd953b24bd588c37
     */
    public function getnbltotal() :int {
        $this->con->executeQuery("SELECT COUNT(*) FROM liste WHERE Public=0");
        return intval($this->con->getResults()[0]['COUNT(*)']);
    }

    /*
     * Recherche l'id maximum dans la base de données des listes
     */
    public function getnbl() :int {
        $this->con->executeQuery("SELECT MAX(IdListe) FROM liste");
        return intval($this->con->getResults()[0]['MAX(IdListe)']);
    }



    /*
     * Fonction pour trouver une liste avec son id
     */
    public function FindByIdOne(int $nom): array{
        $query= 'select * from liste where IdListe=:nom';
        $this->con->executeQuery($query, array( ':nom'=>array($nom,PDO::PARAM_INT)));
        $results=$this->con->getResults();
        if($results){
            Foreach ($results as $row)
                $Tab_de_list[] = new Liste($row['IdListe'], $row['NomDeListe'], $row['Public'], $row['IdPersonne']);
        }else{
            $Tab_de_list = [];
        }

        return $Tab_de_list;
    }

    /*
     * Fonction pour trouver une liste par son nom
     */
    public function FindByNameOne(string $nom): array{
        $query= 'select * from liste where NomDeListe=:nom';
        $this->con->executeQuery($query, array( ':nom'=>array($nom,PDO::PARAM_STR)));
        $results=$this->con->getResults();
        Foreach ($results as $row)
            $Tab_de_list[] = new Liste($row['IdListe'], $row['NomDeListe'], $row['Public'], $row['IdPersonne']);
        return $Tab_de_list;
    }

    /*
     * Recherche toutes les listes public
     */
    public function findByPublic(): array{
        $query= 'select * from liste where Public = 0';
        $this->con->executeQuery($query);
        $results=$this->con->getResults();
        if($results){
            Foreach ($results as $row)
                $Tab_de_list[] = new Liste($row['IdListe'], $row['NomDeListe'], $row['Public'], $row['IdPersonne']);

        }else{
            $Tab_de_list = [];
        }
        return $Tab_de_list;
    }

    /*
     * Recherche une liste par rapport a son utilisateur
     */
    public function findByIdUser(int $d): array{
        $query= 'select * from liste where IdPersonne ='.$d;
        $this->con->executeQuery($query);
        $results=$this->con->getResults();
        if($results){
            Foreach ($results as $row)
                $Tab_de_list[] = new Liste($row['IdListe'], $row['NomDeListe'], $row['Public'], $row['IdPersonne']);

        }else{
            $Tab_de_list = [];
        }
        return $Tab_de_list;
    }

    /*
     * Afficher une liste
     */
    public function afficherTbListe(array $tab){
        foreach ($tab as $r){
            $e = $r->getNomDeListe();

            echo '
                <input type="submit" name="laliste" class="bouttonlistes" value="'.$e.'"/>
                <br>
            ';
        }
    }

    /*
     * Supprimer une liste
     */
    public function SupprimerList(int $l){
        $query= 'delete from liste where IdListe = '.$l;
        $this->con->executeQuery($query);
    }

    /*
     * Supprimer toutes les tâche d'un liste donnée
     */
    public function SupprimerTTeLesTaches(int $l){
        $query= 'delete from tache where IdDeListe = '.$l;
        $this->con->executeQuery($query);
    }

    /*
     * Recherche le nombre total des listes d'un utilisateur
     */

    public function getnbltotalpriv(int $id) :int {
        $this->con->executeQuery("SELECT COUNT(*) FROM liste WHERE Public=0 AND IdPersonne=".$id);
        return intval($this->con->getResults()[0]['COUNT(*)']);
    }

    public function getnbltotalpub(int $id) :int {
        $this->con->executeQuery("SELECT COUNT(*) FROM liste WHERE Public=1 AND IdPersonne=".$id);
        return intval($this->con->getResults()[0]['COUNT(*)']);
    }

}