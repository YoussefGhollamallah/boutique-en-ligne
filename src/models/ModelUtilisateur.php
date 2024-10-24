<?php
require_once __DIR__ . '/../../config/connexion.php';

class ModelUtilisateur 
{
    private $connexion;


    public function __construct(){
        $conn = new Connexion();
        $this->connexion = $conn->connexionBDD();
        $this->connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getAllUsers()
    {
        try{
            $requete = $this->connexion->prepare("SELECT * FROM Utilisateur 
            INNER JOIN Role ON Utilisateur.role_id = Role.id_role");
        $requete->execute();
        $result = $requete->fetchAll(PDO::FETCH_ASSOC);
        return $result;
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la récupération des utilisateurs : " . $e->getMessage());
        }
    }

    public function getRoles()
    {
        try{
            $requete = $this->connexion->prepare("SELECT * FROM Role");
            $requete->execute();
            $result = $requete->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la récupération des rôles : " . $e->getMessage());
        }
    }

}