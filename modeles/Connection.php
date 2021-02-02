<?php
/*
 * Classe de connexion
 */

class Connection extends PDO{
    private $stmt;
    /*
     * Constructeur pour se connecter
     */
    public function __construct(string $dsn, string $username, string $password) {
        parent::__construct($dsn,$username,$password);
        $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /*
     * Executer une requete SQL
     */
    public function executeQuery(string $query, array $parameters = []) :bool {
        $this->stmt = parent::prepare($query);
        foreach ($parameters as $name => $value) {
            $this->stmt->bindValue($name, $value[0], $value[1]);
        }
        return $this->stmt->execute();
    }

    /*
     * Avoir les résultats d'une requete SQL
     */
    public function getResults(): array {
        return $this->stmt->fetchall();
    }

}