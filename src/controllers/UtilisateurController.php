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

    public function getRoles()
    {
        return $this->modelUtilisateur->getRoles();
    }
    public function updateUser($userId, $nom, $prenom, $email, $role_id)
    {
        return $this->modelUtilisateur->updateUser($userId, $nom, $prenom, $email, $role_id);
    }
}