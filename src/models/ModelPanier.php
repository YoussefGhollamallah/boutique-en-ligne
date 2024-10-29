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
                $quantiteDisponible = $this->getQuantiteDisponible($idProduit);
                $_SESSION['panier'][$idProduit] = [
                    'nom' => $produit['nom'],
                    'description' => $produit['description'],
                    'prix' => $produit['prix'],
                    'image' => $produit['image'],
                    'quantite' => min($quantite, $quantiteDisponible),
                    'quantite_max' => $quantiteDisponible,
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
        if (!isset($_SESSION['panier'])) {
            $_SESSION['panier'] = []; // Initialiser le panier si non défini
        }
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
    $_SESSION['montant_total'] = $total; // Met à jour le total en session
    return $total;
}


    public function getQuantiteDisponible($id)
    {
        try {
            $requete = $this->connexion->prepare("SELECT quantite FROM Produit WHERE id = :id");
            $requete->execute(['id' => $id]);
            $resultat = $requete->fetch(PDO::FETCH_ASSOC);
            return $resultat['quantite'] ?? 0; // Renvoie 0 si aucune quantité n'est trouvée
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la récupération de la quantité disponible : " . $e->getMessage());
        }
    }

    public function enregistrerCommande($userId, $statut = 'en cours', $dateCommande = null)
    {
        if (is_null($dateCommande)) {
            $dateCommande = date('Y-m-d H:i:s'); // Date actuelle si non fournie
        }

        try {
            $requete = $this->connexion->prepare("INSERT INTO Commandes (user_id, statut, date_commande) VALUES (:userId, :statut, :dateCommande)");
            $requete->execute([
                'userId' => $userId,
                'statut' => $statut,
                'dateCommande' => $dateCommande
            ]);
            return $this->connexion->lastInsertId(); // Renvoie l'ID de la commande créée
        } catch (Exception $e) {
            throw new Exception("Erreur lors de l'enregistrement de la commande : " . $e->getMessage());
        }
    }
}
?>
