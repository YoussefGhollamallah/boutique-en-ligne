<?php

class UtilisateurController{
    private $modelUtilisateur;
    public function __construct()
    {
        $this->modelUtilisateur = new ModelUtilisateur();
    }

    public function getAllUsers()
    {
        return $this->modelUtilisateur->getAllUsers();
    }

}