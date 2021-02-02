<?php
/*
 * Classe Tache
 */

class Tache
{
    protected $IdTache;
    protected $NomDeTache;
    protected $Fait;
    protected $IdListe;

    function __construct(int $id, string $nom, bool $etat, int $idL){
        $this->IdTache = $id;
        $this->NomDeTache = $nom;
        $this->Fait = $etat;
        $this->IdListe = $idL;
    }

    /**
     * @return int
     */
    public function getIdListe(): int
    {
        return $this->IdListe;
    }

    /**
     * @return string
     */
    public function getNomDeTache(): string
    {
        return $this->NomDeTache;
    }

    /**
     * @return bool
     */
    public function isFait(): bool
    {
        return $this->Fait;
    }

    /**
     * @return int
     */
    public function getIdTache(): int
    {
        return $this->IdTache;
    }

}