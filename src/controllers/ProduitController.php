<?php

class ProduitController
{
    private $modelProduit;
    private $connexion;

    public function __construct()
    {
        // Instancier la classe Connexion
        $conn = new Connexion();
        $this->connexion = $conn->connexionBDD(); // Appeler la méthode connexionBDD()

        $this->modelProduit = new ModelProduit();
    }

    public function getAllProducts()
    {
        // Appeler la méthode getAllProducts de ModelProduit
        $products = $this->modelProduit->getAllProducts();

        // Ferme la connexion après la requête
        $this->connexion = null;

        return $products;
    }
}
?>
