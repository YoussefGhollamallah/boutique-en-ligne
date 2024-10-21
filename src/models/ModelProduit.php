<?php

require_once 'connexion.php';

class ModelProduit
{
    private $connexion;

    public function __construct()
    {
        $this->connexion = connexionBDD();
        $this->connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getAllProducts()
    {
        $requete = $this->connexion->prepare("SELECT * FROM Produit INNER JOIN Categorie ON Produit.id_categorie = Categorie.id_categorie INNER JOIN SousCategorie ON Produit.id_sousCategorie = SousCategorie.id_sousCategorie");
        $requete->execute();
        return $requete->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductById($id)
    {
        $requete = $this->connexion->prepare("SELECT * FROM Produit WHERE id = :id");
        $requete->execute(['id' => $id]);
        return $requete->fetch(PDO::FETCH_ASSOC);
    }

    public function addProduct($nom, $description, $prix, $quantite, $image, $categorie, $sous_categorie)
    {
        $date_ajout = date('Y-m-d h:i:s');
        $requete = $this->connexion->prepare("INSERT INTO Produit (id,nom, description, prix, quantite, image, date_ajout, categorie, sous_categorie) VALUES (null, ?, ?, ?, ?, ?, ?, ?, ?)");
        $requete->execute([$nom, $description, $prix, $quantite, $image, $date_ajout, $categorie, $sous_categorie]);
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
            error_log("No updates to perform");
            return false;
        }

        $query = "UPDATE Produit SET " . implode(', ', $updates) . " WHERE id = :id";
        $params['id'] = $id;

        error_log("Query: " . $query);
        error_log("Params: " . print_r($params, true));

        $stmt = $this->connexion->prepare($query);
        $result = $stmt->execute($params);

        if (!$result) {
            error_log("Error executing query: " . print_r($stmt->errorInfo(), true));
        }

        return $result;
    }

}
