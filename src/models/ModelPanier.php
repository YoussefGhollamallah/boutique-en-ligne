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
