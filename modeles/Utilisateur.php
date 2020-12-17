<?php


class Utilisateur
{
    protected $Idpersonne;
    protected $Nom;
    protected $Prenom;
    protected $Email;
    protected $Password;

    function __construct(int $id, string $nom, string $prenom, string $lemail, string $mdp){
        $this->Idpersonne = $id;
        $this->Nom = $nom;
        $this->Prenom = $prenom;
        $this->Email = $lemail;
        $this->Password = $mdp;
    }

    function get_IDpersonne(): int {
        return $this->Idpersonne;
    }
    function get_nom(): string {
        return $this->Nom;
    }
    function get_prenom(): string {
        return $this->Prenom;
    }
    function get_Email(): string {
        return $this->Email;
    }
    function get_Password(): string {
        return $this->Password;
    }






}