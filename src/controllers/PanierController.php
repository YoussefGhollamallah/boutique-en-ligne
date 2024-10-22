<?php

class PanierController
{
    private $modelPanier;

    public function __construct()
    {
        $this->modelPanier = new ModelPanier();
    }

    public function ajouterProduitAuPanier($idProduit, $quantite)
    {
        $this->modelPanier->ajouterProduit($idProduit, $quantite);
        header("Location: index.php");
        exit();
    }

    public function afficherPanier()
    {
        return isset($_SESSION['panier']) ? $_SESSION['panier'] : [];
    }
}
