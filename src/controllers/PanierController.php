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
        return $this->modelPanier->getPanier();
    }

    public function ajouterProduitAuPanier($idProduit, $quantite = 1, $checked = false)
    {
        $this->modelPanier->ajouterProduit($idProduit, $quantite, $checked);
    }

    public function supprimerProduit($idProduit)
    {
        return $this->modelPanier->supprimerProduitDuPanier($idProduit);
    }


    public function mettreAJourCheckedProduit($idProduit, $checked)
    {
        return $this->modelPanier->mettreAJourChecked($idProduit, $checked);
    }

    public function mettreAJourQuantite($idProduit, $quantite)
    {
        $quantiteMax = $this->modelPanier->getQuantiteDisponible($idProduit);
        $quantiteAjustee = min($quantite, $quantiteMax);
        return $this->modelPanier->mettreAJourQuantite($idProduit, $quantiteAjustee);
    }
}
?>