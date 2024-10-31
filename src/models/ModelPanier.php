<?php

class ModelPanier
{
    private $connexion;

    public function __construct()
    {
        $conn = new Connexion;
        $this->connexion = $conn->connexionBDD();
        $this->connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function ajouterProduit($userId, $idProduit, $quantite = 1, $checked = false)
    {
        $stmt = $this->connexion->prepare("INSERT INTO Panier (user_id, produit_id, quantite, checked, date_ajout) 
                                           VALUES (:user_id, :produit_id, :quantite, :checked, CURRENT_TIMESTAMP)
                                           ON DUPLICATE KEY UPDATE 
                                           quantite = quantite + :quantite,
                                           date_ajout = CURRENT_TIMESTAMP");
        $stmt->execute([
            ':user_id' => $userId,
            ':produit_id' => $idProduit,
            ':quantite' => $quantite,
            ':checked' => $checked
        ]);
    }

    public function getPanier($userId)
    {
        $stmt = $this->connexion->prepare("SELECT p.*, pr.nom, pr.prix, pr.image, pr.description, pr.quantite AS quantite_disponible
                                           FROM Panier p
                                           JOIN Produit pr ON p.produit_id = pr.id
                                           WHERE p.user_id = :user_id
                                           ORDER BY p.date_ajout DESC");
        $stmt->execute([':user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function supprimerProduit($userId, $idProduit)
    {
        $stmt = $this->connexion->prepare("DELETE FROM Panier WHERE user_id = :user_id AND produit_id = :produit_id");
        return $stmt->execute([':user_id' => $userId, ':produit_id' => $idProduit]);
    }

    public function mettreAJourQuantite($userId, $idProduit, $quantite)
{
    $stmt = $this->connexion->prepare("UPDATE Panier SET quantite = :quantite WHERE user_id = :user_id AND produit_id = :produit_id");
    if (!$stmt->execute([':quantite' => $quantite, ':user_id' => $userId, ':produit_id' => $idProduit])) {
        error_log(print_r($stmt->errorInfo(), true)); // Log des erreurs
    }
}

public function mettreAJourChecked($userId, $idProduit, $checked)
{
    $stmt = $this->connexion->prepare("UPDATE Panier SET checked = :checked WHERE user_id = :user_id AND produit_id = :produit_id");
    if (!$stmt->execute([':checked' => $checked, ':user_id' => $userId, ':produit_id' => $idProduit])) {
        error_log(print_r($stmt->errorInfo(), true)); // Log des erreurs
    }
}

    public function calculerTotalPanier($userId)
    {
        $stmt = $this->connexion->prepare("SELECT SUM(p.quantite * pr.prix) as total 
                                           FROM Panier p 
                                           JOIN Produit pr ON p.produit_id = pr.id 
                                           WHERE p.user_id = :user_id AND p.checked = 1");
        $stmt->execute([':user_id' => $userId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }

    public function supprimerProduitsCochesPourUtilisateur($userId)
    {
        $stmt = $this->connexion->prepare("DELETE FROM Panier WHERE user_id = :user_id AND checked = 1");
        return $stmt->execute([':user_id' => $userId]);
    }

    public function validerCommande($userId, $status = 'en attente')
{
    // Démarrer une transaction
    $this->connexion->beginTransaction();

    try {
        // Créer la commande
        $stmt = $this->connexion->prepare("INSERT INTO Commande (status, id_utilisateur) VALUES (:status, :user_id)");
        $stmt->execute([':status' => $status, ':user_id' => $userId]);
        
        // Récupérer l'ID de la commande insérée
        $commandeId = $this->connexion->lastInsertId();

        // Récupérer les produits cochés
        $stmt = $this->connexion->prepare("SELECT * FROM Panier WHERE user_id = :user_id AND checked = 1");
        $stmt->execute([':user_id' => $userId]);
        $produits = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Insérer les produits dans commande_produits
        $stmt = $this->connexion->prepare("INSERT INTO commande_produits (commande_id, produit_id, quantite) VALUES (:commande_id, :produit_id, :quantite)");

        foreach ($produits as $produit) {
            $stmt->execute([
                ':commande_id' => $commandeId,
                ':produit_id' => $produit['produit_id'],
                ':quantite' => $produit['quantite']
            ]);
        }

        // Si tout s'est bien passé, valider la transaction
        $this->connexion->commit();

    } catch (Exception $e) {
        // En cas d'erreur, annuler la transaction
        $this->connexion->rollBack();
        throw new Exception("Erreur lors de la validation de la commande : " . $e->getMessage());
    }
}

}

