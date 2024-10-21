<?php

class HomeController
{
    // Pour afficher la page index
    public function showHome()
    {
        $title = "Pixel Plush";
        $myView = new View('index');
        $myView->setVars(['title' => $title]);  // Passer la variable $title à la vue
        $myView->render(); // Passer les variables dans les parenthèse pour afficher les objets
    }

    // Pour afficher la page panier
    public function showPanier()
    {
        $title = "Pixel Plush - Mon Panier";
        $myView = new View('panier');
        $myView->setVars(['title' => $title]);
        $myView->render();
    }

    // Pour afficher la page404
    public function show404()
    {
        $title = 'Pixel Plush - Erreur 404';
        $myView = new View('page404');
        $myView->setVars(['title' => $title]);
        $myView->render();
    }

    // Pour afficher la page categories
    public function showCategories()
    {
        $title = 'Pixel Plush - Categories';
        $myView = new View('categories');
        $myView->setVars(['title' => $title]);
        $myView->render();
    }

    // Pour afficher la page profil
    public function showProfil()
    {
        $title = 'Pixel Plush - Mon Profil';
        $myView = new View('profil');
        $myView->setVars(['title' => $title]);
        $myView->render();
    }

    // Pour afficher la page connexion
    public function showConnexion()
    {
        $title = 'Pixel Plush - Connexion';
        $myView = new View('connexion');
        $myView->setVars(['title' => $title]);
        $myView->render();
    }

    // Pour afficher la page detail
    public function showDetail()
    {
        $title = 'Pixel Plush - Détails';
        $myView = new View('detail');
        $myView->setVars(['title' => $title]);
        $myView->render();
    }
}
?>