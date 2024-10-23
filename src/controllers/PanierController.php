<?php

class PanierController
{
    private $modelPanier;

    public function __construct()
    {
        $this->modelPanier = new ModelPanier();
    }

    public function ajouterProduitAuPanier($idProduit, $quantite, $checked = false)
    {
        $this->modelPanier->ajouterProduit($idProduit, $quantite, $checked);
        header("Location: index.php");
        exit();
    }

    public function afficherPanier()
    {
        return $this->modelPanier->getPanier();
    }

    public function mettreAJourChecked($idProduit, $checked)
    {
        $this->modelPanier->mettreAJourChecked($idProduit, $checked);
    }

    public function supprimerProduit($idProduit)
    {
        $this->modelPanier->supprimerProduitDuPanier($idProduit);
    }

    public function mettreAJourQuantite($idProduit, $quantite)
    {
        $this->modelPanier->mettreAJourQuantite($idProduit, $quantite);
    }
}
