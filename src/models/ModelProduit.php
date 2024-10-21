<?php

class ModelProduit
{
    private $connexion;

    public function __construct()
    {
        // Instancier la classe Connexion
        $conn = new Connexion();
        $this->connexion = $conn->connexionBDD();
        $this->connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getAllProducts()
    {
        $requete = $this->connexion->prepare("SELECT * FROM Produit INNER JOIN Categorie ON Produit.id_categorie = Categorie.id_categorie INNER JOIN SousCategorie ON Produit.id_sousCategorie = SousCategorie.id_sousCategorie");
        $requete->execute();
        return $requete->fetchAll(PDO::FETCH_ASSOC);
    }

    // Les autres méthodes restent inchangées...
}
?>
