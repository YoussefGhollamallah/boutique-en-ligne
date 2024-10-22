<?php
class ModelPanier
{
    private $connexion;

    public function __construct()
    {
        $conn = new Connexion();
        $this->connexion = $conn->connexionBDD();
    }

    public function getPanier()
    {
        if (!isset($_SESSION['panier'])) {
            $_SESSION['panier'] = [];
        }
        return $_SESSION['panier'];
    }

    public function ajouterProduit($idProduit, $quantite = 1)
{
    if (!isset($_SESSION['panier'])) {
        $_SESSION['panier'] = [];
    }

    // Si le produit est déjà dans le panier, augmenter la quantité
    if (isset($_SESSION['panier'][$idProduit])) {
        $_SESSION['panier'][$idProduit]['quantite'] += $quantite;
    } else {
        // Sinon, ajouter un nouveau produit avec la quantité
        $requete = $this->connexion->prepare("SELECT * FROM Produit WHERE id = :id");
        $requete->execute(['id' => $idProduit]);
        $produit = $requete->fetch(PDO::FETCH_ASSOC);

        if ($produit) {
            $_SESSION['panier'][$idProduit] = [
                'nom' => $produit['nom'],
                'prix' => $produit['prix'],
                'image' => $produit['image'],
                'quantite' => $quantite
            ];
        }
    }
}


    public function updateQuantite($idProduit, $quantite)
    {
        if (isset($_SESSION['panier'][$idProduit])) {
            $_SESSION['panier'][$idProduit]['quantite'] = $quantite;
        }
    }

    public function supprimerProduit($idProduit)
    {
        if (isset($_SESSION['panier'][$idProduit])) {
            unset($_SESSION['panier'][$idProduit]);
        }
    }

    public function validerCommande()
    {
        // Code pour gérer la validation de la commande, par exemple enregistrer dans la base de données
        $_SESSION['panier'] = [];  // Vider le panier après validation
    }
}
?>
