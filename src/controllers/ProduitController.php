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
        return $this->modelProduit->getAllProducts();
    }
}
?>
