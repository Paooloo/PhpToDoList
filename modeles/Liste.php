<?php


class Liste
{
    protected $IdListe;
    protected $NomDeListe;
    protected $EstPublic;
    protected $IdPersonne;

    function __construct(int $idl, string $nom, bool $etat, int $idp){
        $this->IdListe = $idl;
        $this->NomDeListe = $nom;
        $this->EstPublic = $etat;
        $this->IdPersonne = $idp;
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
    public function getNomDeListe(): string
    {
        return $this->NomDeListe;
    }

    /**
     * @return bool
     */
    public function isPublic(): bool
    {
        return $this->EstPublic;
    }

    /**
     * @return int
     */
    public function getIdPersonne(): int
    {
        return $this->IdPersonne;
    }

}