<?php

class ControllerCommande
{
    private $modelCommande;

    public function __construct()
    {
        $this->modelCommande = new ModelCommande();
    }

    // Fonction pour obtenir l'historique des commandes d'un utilisateur
    public function afficherCommandesUtilisateur($userId)
    {
        return $this->modelCommande->getAllCommandeById($userId);
    }

    // Fonction pour obtenir toutes les commandes (pour l'admin)
    public function afficherToutesLesCommandes()
    {
        return $this->modelCommande->getAllCommande();
    }
}
?>