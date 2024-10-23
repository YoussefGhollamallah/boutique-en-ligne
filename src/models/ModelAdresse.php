<?php
require_once __DIR__ . '/../../config/connexion.php';

class ModelAdresse
{
    private $connexion;


    public function __construct()
    {
        $conn = new Connexion();
        $this->connexion = $conn->connexionBDD();
        $this->connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    public function getAdresse($user_id)
    {
        try {
            // Prépare la requête avec un paramètre nommé
            $requete = $this->connexion->prepare("SELECT * FROM Adresse WHERE id_utilisateur = :id");
            
            // Exécute la requête en associant le paramètre nommé
            $requete->execute(['id' => $user_id]);
            
            // Récupère le résultat
            $result = $requete->fetch(PDO::FETCH_ASSOC);
            
            return $result;
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la récupération de l'adresse : " . $e->getMessage());
        }
    }
    
}
