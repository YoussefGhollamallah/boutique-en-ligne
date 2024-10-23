<?php

require_once __DIR__ . '/../../config/connexion.php';

class ModelProduit
{
    private $connexion;

    public function __construct()
    {
        $conn = new Connexion();
        $this->connexion = $conn->connexionBDD();
        $this->connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getAllProducts()
    {
        try {
            $requete = $this->connexion->prepare("SELECT * FROM Produit 
                INNER JOIN Categorie ON Produit.id_categorie = Categorie.id_categorie 
                INNER JOIN SousCategorie ON Produit.id_sousCategorie = SousCategorie.id_sousCategorie");
            $requete->execute();
            $result = $requete->fetchAll(PDO::FETCH_ASSOC);

            return $result;
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la récupération des produits : " . $e->getMessage());
        }
    }

    public function getProductById($id)
    {
        try {
            $requete = $this->connexion->prepare("SELECT * FROM Produit WHERE id = :id");
            $requete->execute(['id' => $id]);
            $result = $requete->fetch(PDO::FETCH_ASSOC);

            return $result;
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la récupération du produit : " . $e->getMessage());
        }
    }

    public function addProduct($nom, $description, $prix, $quantite, $image, $categorie, $sous_categorie)
    {
        try {
            $requete = $this->connexion->prepare("INSERT INTO Produit 
                (nom, description, prix, quantite, image, date_ajout, id_categorie, id_sousCategorie) 
                VALUES (?, ?, ?, ?, ?, NOW(), ?, ?)");
            $requete->execute([$nom, $description, $prix, $quantite, $image, $categorie, $sous_categorie]);
        } catch (Exception $e) {
            throw new Exception("Erreur lors de l'ajout du produit : " . $e->getMessage());
        }
    }

    public function updateProduct($id, $data)
    {
        $allowedFields = ['nom', 'description', 'prix', 'quantite'];
        $updates = [];
        $params = [];

        foreach ($allowedFields as $field) {
            if (isset($data[$field])) {
                $updates[] = "$field = :$field";
                $params[$field] = $data[$field];
            }
        }

        if (empty($updates)) {
            throw new Exception("Aucune mise à jour à effectuer.");
        }

        $query = "UPDATE Produit SET " . implode(', ', $updates) . " WHERE id = :id";
        $params['id'] = $id;

        try {
            $stmt = $this->connexion->prepare($query);
            $result = $stmt->execute($params);

            if (!$result) {
                throw new Exception("Erreur lors de la mise à jour du produit.");
            }

            return $result;
        } catch (Exception $e) {
            throw new Exception("Erreur lors de l'exécution de la requête : " . $e->getMessage());
        }
    }

    public function getLastThreeProducts()
    {
        try {
            $requete = $this->connexion->prepare("SELECT * FROM Produit ORDER BY date_ajout DESC LIMIT 3");
            $requete->execute();
            return $requete->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la récupération des derniers produits : " . $e->getMessage());
        }
    }
}
