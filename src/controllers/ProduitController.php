<?php

require_once __DIR__ . '/../../config/connexion.php';
require_once __DIR__ . '/../models/ModelProduit.php';

class ProduitController
{
    private $modelProduit;
    private $connexion;
    public function __construct()
    {
        $this->connexion = connexionBDD();
        $this->modelProduit = new ModelProduit();
    }

    public function getAllProducts()
    {
        return $this->modelProduit->getAllProducts();
    }
    
}