<?php

class ModelPanier
{
    private $connexion;

    public function __construct()
    {
        $conn = new Connexion();
        $this->connexion = $conn->connexionBDD();
        $this->connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function ajouterProduit($idProduit, $quantite = 1, $checked = false)
    {
        if (!isset($_SESSION['panier'])) {
            $_SESSION['panier'] = [];
        }

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
                    'id' => $produit['id'] // Assurez-vous d'ajouter l'id du produit ici
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
        try {
            $requete = $this->connexion->prepare("SELECT * FROM Produit WHERE id = :id");
            $requete->execute(['id' => $id]);
            return $requete->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la récupération du produit : " . $e->getMessage());
        }
    }

    public function supprimerProduitDuPanier($idProduit)
{
    if (isset($_SESSION['panier'][$idProduit])) {
        unset($_SESSION['panier'][$idProduit]);
        return true; // Assure que le produit est bien supprimé
    }
    return false;
}

    public function mettreAJourQuantite($idProduit, $quantite)
    {
        if (isset($_SESSION['panier'][$idProduit]) && $quantite > 0) {
            $_SESSION['panier'][$idProduit]['quantite'] = $quantite;
        }
    }

    public function getPanier()
    {
        return isset($_SESSION['panier']) ? $_SESSION['panier'] : [];
    }
}
