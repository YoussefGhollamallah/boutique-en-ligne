<?php
session_start();

class ModelPanier
{
    private $connexion;

    public function __construct()
    {
        $conn = new Connexion();
        $this->connexion = $conn->connexionBDD();
        $this->connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function ajouterProduit($idProduit, $quantite = 1)
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
                    'quantite' => $quantite
                ];
            }
        }
    }

    public function getProduct($id)
    {
        try {
            $requete = $this->connexion->prepare("SELECT * FROM Produit WHERE id = :id");
            $requete->execute(['id' => $id]);
            return $requete->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la récupération du produit : " . $e->getMessage());
        } finally {
            $this->connexion = null;
        }
    }

    public function supprimerProduitDuPanier($idProduit)
    {
        if (isset($_SESSION['panier'][$idProduit])) {
            unset($_SESSION['panier'][$idProduit]);
            return true;
        }
        return false;
    }
}
