<?php

class Home
{
    // Pour afficher la page index (en POO)
    public function showHome()
    {
        include_once (VIEW.'index.php'); // Mettre un "/" devant index.php en cas de problème
    }

    public function showPanier()
    {
        include_once (VIEW.'panier.php'); // Mettre un "/" devant index.php en cas de problème
    }
}





?>