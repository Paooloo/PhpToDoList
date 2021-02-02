<?php
/*
 * Classe Gateway (protection) de l'utilisateur
 */

require_once('Connection.php');
require_once('Utilisateur.php');
class GatewayUtilisateur
{
    private $con;

    /*
     * Constructeur qui nécessite une connection
     */
    function __construct(Connection $con){
        $this->con = $con;
    }

    /*
     * Fonction pour insérer un utilisateur
     */
    public function insert(Utilisateur $u): int {
        $query = 'INSERT INTO utilisateur VALUES(:Idpersonne,:Nom,:Prenom,:Email, :Password)';
        $this->con->executeQuery($query, array(':Idpersonne' => array($u->get_IDpersonne(),PDO::PARAM_INT),':Nom' => array($u->get_nom(),PDO::PARAM_STR),':Prenom' => array($u->get_prenom(),PDO::PARAM_STR),':Email' => array($u->get_Email(),PDO::PARAM_STR),':Password' => array($u->get_Password(),PDO::PARAM_STR)));
        return $this->con->lastInsertId();
    }


    /*
     * Fonction pour trouver un utilisateur via son email
     */
    public function FindByEmail (string $email): array{
        $query=' select * from utilisateur where Email=:email';
        $this->con->executeQuery($query, array( ':email'=> array($email,PDO::PARAM_STR)));

        $results=$this->con->getResults();
        Foreach ($results as $row)
            $Tab_de_Utilisateur[]=new Utilisateur($row['Idpersonne'], $row['Nom'], $row['Prenom'], $row['Email'], $row['Password']);
        Return $Tab_de_Utilisateur;
    }

    /*
     * Recherche l'id maximum dans la données des utilisateurs
     */
    public function getnbu() :int {
        $this->con->executeQuery("SELECT MAX(Idpersonne) FROM utilisateur");
        return intval($this->con->getResults()[0]['MAX(Idpersonne)']);
    }

}