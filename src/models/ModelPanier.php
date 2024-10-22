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
    // Récupérer les produits dans le panier
    $requete = $this->connexion->prepare("SELECT * FROM Panier INNER JOIN Produit ON Panier.id_produit = Produit.id");
    $requete->execute();
    
    // Retourne un tableau vide si aucun produit n'est trouvé
    return $requete->fetchAll(PDO::FETCH_ASSOC) ?: [];
}


    public function updateQuantite($idProduit, $quantite)
    {
        $requete = $this->connexion->prepare("UPDATE Panier SET quantite = :quantite WHERE id_produit = :id");
        $requete->execute(['quantite' => $quantite, 'id' => $idProduit]);
    }

    public function supprimerProduit($idProduit)
    {
        $requete = $this->connexion->prepare("DELETE FROM Panier WHERE id_produit = :id");
        $requete->execute(['id' => $idProduit]);
    }
}
?>
