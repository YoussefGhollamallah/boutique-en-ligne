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
    $this->modelPanier->mettreAJourQuantite($idProduit, $quantiteAjustee);
    
    // Recalculez et stockez le total après chaque mise à jour
    $_SESSION['montant_total'] = $this->calculerTotalPanier();
}


    public function enregistrerCommande($userId, $statut = 'en cours', $dateCommande = null)
    {
        if (is_null($dateCommande)) {
            $dateCommande = date('Y-m-d H:i:s'); // Date actuelle si non fournie
        }
        return $this->modelPanier->enregistrerCommande($userId, $statut, $dateCommande);
    }

    public function calculerTotalPanier()
    {
        return $this->modelPanier->calculerTotalPanier();
    }
}
?>
