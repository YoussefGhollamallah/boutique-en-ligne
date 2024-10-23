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
            // Vérification de la validité de l'ID utilisateur
            if (empty($user_id) || !is_numeric($user_id)) {
                throw new Exception("L'ID utilisateur fourni n'est pas valide.");
            }

            // Appel de la méthode du modèle pour récupérer l'adresse
            $adresse = $this->modelAdresses->getAdresse($user_id);

            // Si aucune adresse n'est trouvée, on renvoie null
            if ($adresse === false || $adresse === null) {
                return null;  // On renvoie null au lieu de lever une exception
            }

            return $adresse;

        } catch (Exception $e) {
            // Renvoi d'une exception avec le message d'erreur
            throw new Exception("Erreur lors de la récupération de l'adresse : " . $e->getMessage());
        }
    }
}
