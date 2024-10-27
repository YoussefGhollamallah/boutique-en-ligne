<?php

class UtilisateurController{
    private $modelUtilisateur;
    public function __construct()
    {
        $this->modelUtilisateur = new ModelUtilisateur();
    }

    public function addUser($prenom, $nom, $email, $password, $id_adresse = null, $role_id = 2)
    {
        return $this->modelUtilisateur->addUser($prenom, $nom, $email, $password, $id_adresse, $role_id);
    }

    public function userConnexion($email, $password)
    {
        return $this->modelUtilisateur->userConnexion($email, $password);
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