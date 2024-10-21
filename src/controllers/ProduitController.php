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
        $produitController = new ProduitController();
        $products = $produitController->getAllProducts();
        return $this->modelProduit->getAllProducts();
    }
}
?>
