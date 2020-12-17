<?php

require_once('Connection.php');
require_once('Tache.php');

class GatewayTache
{
    function __construct(Connection $con){
        $this->con = $con;
    }

    public function insert(Tache $t): int {
        $query = 'INSERT INTO tache VALUES(:IdTache,:NomDeTache,:Fait,:IdDeListe)';
        $this->con->executeQuery($query, array(
            ':IdTache' => array($t->getIdTache(),PDO::PARAM_INT),
            ':NomDeTache' => array($t->getNomDeTache(),PDO::PARAM_STR),
            ':Fait' => array($t->isFait(),PDO::PARAM_BOOL),
            ':IdDeListe' => array($t->getIdListe(),PDO::PARAM_INT)));
        return $this->con->lastInsertId();
    }

    public function FindById (int $id): array{
        $query= 'select * from tache where IdDeListe =:id';
        $this->con->executeQuery($query, array(':id'=> array($id,PDO::PARAM_INT)));
        $results=$this->con->getResults();
        if($results){
            Foreach ($results as $row)
                $Tab_de_tache[] = new Tache($row['IdTache'], $row['NomDeTache'], $row['Fait'], $row['IdDeListe']);
        }else{
            $Tab_de_tache = [];
        }
        return $Tab_de_tache;
    }

    public function FindByNameOne (string $id): Tache{
        $query= 'select * from tache where NomDeTache =:id';
        $this->con->executeQuery($query, array(':id'=> array($id,PDO::PARAM_STR)));
        $results=$this->con->getResults();
        Foreach ($results as $row)
            $Tab_de_tache = new Tache($row['IdTache'], $row['NomDeTache'], $row['Fait'], $row['IdDeListe']);
        return $Tab_de_tache;
    }

    public function getnbt() :int {
        $this->con->executeQuery("SELECT MAX(IdTache) FROM tache");
        return intval($this->con->getResults()[0]['MAX(IdTache)']);
    }


    public function changerAfaire(int $t){
        $query= 'update tache set Fait = 0 where IdTache = '.$t;
        $this->con->executeQuery($query);
    }

    public function changerfait(int $t){
        $query= 'update tache set Fait = 1 where IdTache = '.$t;
        $this->con->executeQuery($query);
    }


    public function afficherTbTache(array $tab){
        foreach ($tab as $r){
            $q = $r->getNomDeTache();
            $e = $r->isFait();
            $v = $r->getIdTache();
            $d = "";
            $msg = "";
            if($e == 0){
                $msg = "Fait";
                $d = "status done";
            }else{
                $msg = "A faire";
                $d = "status";
            }
            echo "
            <li>
                <div name='nomdetache' class='$d'>$msg</div>
                <input class='check-status' type='checkbox' name='task[]' value='$q'/>
                <span>$q</span>
            </li>   
            ";
        }
    }

    public function supprimertache(int $t){
        $query= 'delete from tache where IdTache = '.$t;
        $this->con->executeQuery($query);
    }
}