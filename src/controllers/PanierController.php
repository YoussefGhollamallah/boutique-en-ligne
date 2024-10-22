<?php
class PanierController
{
    private $modelPanier;

    public function __construct()
    {
        session_start();  // Démarrer la session ici
        $this->modelPanier = new ModelPanier();
    }

    public function afficherPanier()
    {
        $produits = $this->modelPanier->getPanier();
        include 'views/panier.php';  // Charger la vue avec les produits du panier
    }

    public function ajouterProduitAuPanier()
{
    $data = json_decode(file_get_contents('php://input'), true);
    $idProduit = $data['id'];
    $quantite = isset($data['quantite']) ? (int)$data['quantite'] : 1;

    $this->modelPanier->ajouterProduit($idProduit, $quantite);
    echo json_encode(['status' => 'success']);
}


    public function updateQuantite()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $idProduit = $data['id'];
        $quantite = $data['quantite'];
        $this->modelPanier->updateQuantite($idProduit, $quantite);
        echo json_encode(['status' => 'success']);
    }

    public function supprimerProduit()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $idProduit = $data['id'];
        $this->modelPanier->supprimerProduit($idProduit);
        echo json_encode(['status' => 'success']);
    }

    public function validerCommande()
    {
        $this->modelPanier->validerCommande();
        echo json_encode(['status' => 'commande_validee']);
    }
}
?>
