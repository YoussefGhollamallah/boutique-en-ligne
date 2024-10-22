<?php

class PanierController
{
    private $modelPanier;

    public function __construct()
    {
        $this->modelPanier = new ModelPanier();
    }

    public function afficherPanier()
    {
        $produits = $this->modelPanier->getPanier();
        include 'views/panier.php'; // Charger la vue avec les produits du panier
    }

    public function updateQuantite($idProduit, $quantite)
    {
        $this->modelPanier->updateQuantite($idProduit, $quantite);
    }

    public function supprimerProduit($idProduit)
    {
        $this->modelPanier->supprimerProduit($idProduit);
    }
}
?>
