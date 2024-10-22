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
        $this->modelPanier->ajouterProduit($idProduit, $quantite);
        header("Location: index.php");
        exit();
    }

    public function afficherPanier()
    {
        return isset($_SESSION['panier']) ? $_SESSION['panier'] : [];
    }

    public function supprimerProduit()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            $idProduit = $data['idProduit'];
            
            // Appel au modèle pour supprimer le produit
            $result = $this->modelPanier->supprimerProduitDuPanier($idProduit);
            
            // Renvoi d'une réponse JSON
            echo json_encode(['success' => $result]);
            exit(); // Assurez-vous d'arrêter le script après la réponse
        }
    }
}
