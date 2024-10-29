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
    
    public function addAdresse($user_id, $adresse, $adresse_complement, $code_postal, $ville, $pays)
    {
        $existAdresse = $this->getAdresse($user_id);
        if ($existAdresse) {
            return $this->updateAdresse($user_id, $adresse, $adresse_complement, $code_postal, $ville, $pays);
    } else {
        try {
            $requete = $this->connexion->prepare("INSERT INTO Adresse (id_utilisateur, adresse, adresse_complement, code_postal, ville, pays) VALUES (:id, :adresse, :adresse_complement, :code_postal, :ville, :pays)");
            
            $requete->execute([
                'id' => $user_id,
                'adresse' => $adresse,
                'adresse_complement' => $adresse_complement,
                'code_postal' => $code_postal,
                'ville' => $ville,
                'pays' => $pays
            ]);
        } catch (Exception $e) {
            throw new Exception("Erreur lors de l'ajout de l'adresse : " . $e->getMessage());
        }
    }
    }

    public function updateAdresse($user_id, $adresse = "", $adresse_complement = "", $code_postal = "", $ville = "", $pays = "")
    {
        try {
            $requete = $this->connexion->prepare("UPDATE Adresse SET adresse = :adresse, adresse_complement = :adresse_complement, code_postal = :code_postal, ville = :ville, pays = :pays WHERE id_utilisateur = :id");
            
            $requete->execute([
                'adresse' => $adresse,
                'adresse_complement' => $adresse_complement,
                'code_postal' => $code_postal,
                'ville' => $ville,
                'pays' => $pays,
                'id' => $user_id
            ]);
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la mise à jour de l'adresse : " . $e->getMessage());
        }
    }
}
