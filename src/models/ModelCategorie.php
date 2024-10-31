<?php
// Path: src/models/ModelCategorie.php
require_once __DIR__ . '/../../config/connexion.php';

class ModelCategorie
{
    private $connexion;

    public function __construct()
    {
        $conn = new Connexion();
        $this->connexion = $conn->connexionBDD();
        $this->connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getAllCategorie()
    {
        try {
            $stmt = $this->connexion->prepare('SELECT * FROM Categorie');
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la récupération des catégories : " . $e->getMessage());
        }
    }

    public function getAllSousCategories()
    {
        try {
            $stmt = $this->connexion->prepare('SELECT * FROM SousCategorie');
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la récupération des sous-catégories : " . $e->getMessage());
        }
    }

    public function getAllProductsBycategorie($categorieId)
    {
        try {
            $stmt = $this->connexion->prepare('
                SELECT Produit.* FROM Produit
                INNER JOIN Categorie ON Produit.id_categorie = Categorie.id_categorie
                WHERE Categorie.id_categorie = ?
            ');
            $stmt->execute([$categorieId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la récupération des produits : " . $e->getMessage());
        }
    }

    public function getSousCategoriesByCategory($categorieId)
    {
        try {
            $stmt = $this->connexion->prepare('
                SELECT * FROM SousCategorie
                WHERE id_categorie = ?
            ');
            $stmt->execute([$categorieId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la récupération des sous-catégories : " . $e->getMessage());
        }
    }


}
