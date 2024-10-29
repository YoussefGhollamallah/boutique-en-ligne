<?php

class UtilisateurController{
    private $modelUtilisateur;
    public function __construct()
    {
        $this->modelUtilisateur = new ModelUtilisateur();
    }

    public function addUser($prenom, $nom, $email, $password, $id_adresse = null, $role_id = 2)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        return $this->modelUtilisateur->addUser($prenom, $nom, $email, $hashedPassword, $id_adresse, $role_id);
    }

    public function userConnexion($email, $password)
    {
        return $this->modelUtilisateur->userConnexion($email, $password);
    }

    public function getAllUsers()
    {
        return $this->modelUtilisateur->getAllUsers();
    }

    public function resetPassword($email, $password)
        {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $result = $this->modelUtilisateur->resetPassword($email, $hashedPassword);
            
            if ($result) {
                return "Le mot de passe a été mis à jour avec succès.";
            } else {
                return "Aucune mise à jour effectuée. L'adresse e-mail est peut-être incorrecte.";
            }
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