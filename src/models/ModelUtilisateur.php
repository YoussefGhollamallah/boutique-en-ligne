<?php

class Utilisateur
{
    
    private $connexion;

    public function __construct()
    {
        $conn = new Connexion();
        $this->connexion = $conn->connexionBDD();
        $this->connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function register($prenom, $nom, $email, $mot_de_passe, $id_adresse = null, $role_id= 2)
    {
        try {
            $requete = $this->connexion->prepare("INSERT INTO Utilisateur (id, prenom, nom, email, mot_de_passe, id_adresse, role_id) VALUES (null, ?, ?, ?, ?, ?, ?, NOW()");
            $requete->execute([$prenom,$nom]);
        }
    }

    public function login($email, $mot_de_passe)
    {

    }

}