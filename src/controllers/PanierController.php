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
        $userId = $_SESSION['user_id'] ?? 0; // Assurez-vous d'avoir un système d'authentification
        $this->modelPanier->ajouterProduit($userId, $idProduit, $quantite);
    }

    public function afficherPanier()
    {
        $userId = $_SESSION['user_id'] ?? 0;
        return $this->modelPanier->getPanier($userId);
    }

    public function supprimerProduit($idProduit)
    {
        $userId = $_SESSION['user_id'] ?? 0;
        return $this->modelPanier->supprimerProduit($userId, $idProduit);
    }

    public function mettreAJourQuantite($idProduit, $quantite)
    {
        $userId = $_SESSION['user_id'] ?? 0;
        $this->modelPanier->mettreAJourQuantite($userId, $idProduit, $quantite);
    }

    public function mettreAJourCheckedProduit($idProduit, $checked)
    {
        $userId = $_SESSION['user_id'] ?? 0;
        $this->modelPanier->mettreAJourChecked($userId, $idProduit, $checked);
    }

    public function calculerTotalPanier()
    {
        $userId = $_SESSION['user_id'] ?? 0;
        return $this->modelPanier->calculerTotalPanier($userId);
    }

    public function supprimerProduitsCochesDuPanier()
    {
        $userId = $_SESSION['user_id'] ?? 0;
        return $this->modelPanier->supprimerProduitsCochesPourUtilisateur($userId);
    }
}