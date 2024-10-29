<?php

class ModelPanier
{
    public function __construct()
    {
        session_start(); // Assurez-vous que la session est démarrée
        if (!isset($_SESSION['panier'])) {
            $_SESSION['panier'] = []; // Initialiser le panier si non défini
        }
    }

    public function ajouterProduit($idProduit, $quantite = 1, $checked = false)
    {
        if (isset($_SESSION['panier'][$idProduit])) {
            $_SESSION['panier'][$idProduit]['quantite'] += $quantite;
        } else {
            $produit = $this->getProduct($idProduit);
            if ($produit) {
                $_SESSION['panier'][$idProduit] = [
                    'nom' => $produit['nom'],
                    'description' => $produit['description'],
                    'prix' => $produit['prix'],
                    'image' => $produit['image'],
                    'quantite' => $quantite,
                    'checked' => $checked,
                    'id' => $produit['id']
                ];
            }
        }
    }

    public function mettreAJourChecked($idProduit, $checked)
    {
        if (isset($_SESSION['panier'][$idProduit])) {
            $_SESSION['panier'][$idProduit]['checked'] = $checked;
            return true;
        }
        return false;
    }

    public function getProduct($id)
    {
        // Ajoutez ici votre code pour récupérer le produit depuis la base de données
    }

    public function supprimerProduitDuPanier($idProduit)
    {
        if (isset($_SESSION['panier'][$idProduit])) {
            unset($_SESSION['panier'][$idProduit]);
            return true;
        }
        return false;
    }

    public function mettreAJourQuantite($idProduit, $quantite)
    {
        if (isset($_SESSION['panier'][$idProduit]) && $quantite > 0) {
            $_SESSION['panier'][$idProduit]['quantite'] = $quantite;
            return true;
        }
        return false;
    }

    public function getPanier()
    {
        return $_SESSION['panier'];
    }

    public function viderPanier()
    {
        $_SESSION['panier'] = [];
    }

    public function calculerTotalPanier()
    {
        $total = 0;
        foreach ($this->getPanier() as $produit) {
            if (isset($produit['checked']) && $produit['checked']) {
                $total += $produit['prix'] * $produit['quantite'];
            }
        }
        return $total;
    }
}
?>
