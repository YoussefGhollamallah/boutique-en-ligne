<?php
// Path: src/controllers/ProduitController.php

class ProduitController
{
    private $modelProduit;

    public function __construct()
    {
        $this->modelProduit = new ModelProduit();
    }

    public function getAllProducts()
    {
        return $this->modelProduit->getAllProducts();
    }

    public function getProductById($id)
    {
        return $this->modelProduit->getProductById($id);
    }

    public function getLastThreeProducts()
    {
        return $this->modelProduit->getLastThreeProducts();
    }

    public function addProduct($nom, $description,  $prix, $quantite,$image, $categorie, $sousCategorie)
    {
        $this->modelProduit->addProduct($nom, $description, $prix, $quantite,$image, $categorie, $sousCategorie);
    }

    public function deleteProduct($id)
    {
        $this->modelProduit->deleteProduct($id);
    }
}
?>
