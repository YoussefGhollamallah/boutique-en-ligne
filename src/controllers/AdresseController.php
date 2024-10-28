<?php

class AdresseController
{
    private $modelAdresses;

    public function __construct()
    {
        // Initialisation du modèle adresse
        $this->modelAdresses = new ModelAdresse();
    }

    // Méthode pour récupérer une adresse à partir d'un identifiant utilisateur
    public function getAdresse($user_id)
    {
        try {
            if (empty($user_id) || !is_numeric($user_id)) {
                throw new Exception("L'ID utilisateur fourni n'est pas valide.");
            }

            $adresse = $this->modelAdresses->getAdresse($user_id);

            if ($adresse === false || $adresse === null) {
                return null;  // On renvoie null au lieu de lever une exception
            }

            return $adresse;

        } catch (Exception $e) {
            throw new Exception("Erreur lors de la récupération de l'adresse : " . $e->getMessage());
        }
    }
    public function updateAdresse($user_id, $adresse = "", $adresse_complement = "", $code_postal = "", $ville = "", $pays = "")
    {
        try {
            if (empty($user_id) || !is_numeric($user_id)) {
                throw new Exception("L'ID utilisateur fourni n'est pas valide.");
            }

            $this->modelAdresses->updateAdresse($user_id, $adresse, $adresse_complement, $code_postal, $ville, $pays);

        } catch (Exception $e) {
            throw new Exception("Erreur lors de la mise à jour de l'adresse : " . $e->getMessage());
        }
    }

    public function addAdresse($user_id, $adresse, $adresse_complement, $code_postal, $ville, $pays)
    {
        try {
            if (empty($user_id) || !is_numeric($user_id)) {
                throw new Exception("L'ID utilisateur fourni n'est pas valide.");
            }

            $this->modelAdresses->addAdresse($user_id, $adresse, $adresse_complement, $code_postal, $ville, $pays);

        } catch (Exception $e) {
            throw new Exception("Erreur lors de l'ajout de l'adresse : " . $e->getMessage());
        }
    }
}
