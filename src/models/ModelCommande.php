<?php

class ModelCommande
{
    private $connexion;

    public function __construct()
    {
        $conn = new Connexion;
        $this->connexion = $conn->connexionBDD();
        $this->connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    // Fonction pour récupérer toutes les commandes d'un utilisateur spécifique
    public function getAllCommandeById($userId)
{
    $stmt = $this->connexion->prepare("
        SELECT c.id AS commande_id, c.date_commande, c.status, cp.quantite, p.nom AS produit_nom
        FROM Commande c
        INNER JOIN Commande_Produit cp ON c.id = cp.commande_id
        INNER JOIN Produit p ON cp.produit_id = p.id
        WHERE c.id_utilisateur = :userId
        ORDER BY c.date_commande DESC
    ");
    $stmt->execute([':userId' => $userId]);
    
    $commandes = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $commandes[$row['commande_id']]['date_commande'] = $row['date_commande'];
        $commandes[$row['commande_id']]['status'] = $row['status'];
        $commandes[$row['commande_id']]['produits'][] = [
            'nom' => $row['produit_nom'],
            'quantite' => $row['quantite'],
        ];
    }

    return $commandes;
}



    // Fonction pour récupérer toutes les commandes (pour l'admin)
    public function getAllCommande()
    {
        $stmt = $this->connexion->query("
            SELECT c.id, c.date_creation, c.status, u.nom, u.prenom
            FROM Commande AS c
            JOIN Utilisateur AS u ON c.id_utilisateur = u.id
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>