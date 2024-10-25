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
        $title = 'Pixel Plush - Catégories';
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
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $produitController = new ProduitController();
        $produit = $produitController->getProductById($_GET['id']);
        
        if ($produit) {
            $view = new View('detail');
            $view->setVars(['produit' => $produit]);
            $view->render();
        } else {
            // Redirige vers la page 404 si le produit n'existe pas
            header("Location: index.php?r=page404");
            exit;
        }
    } else {
        header("Location: index.php?r=page404");
        exit;
    }
}


    public function showAdminProduits()
    {
        $title = 'Pixel Plush - Admin Produits';
        $myView = new View('admin-produits');
        $myView->setVars(['title' => $title]);
        $myView->render();
    }
    public function showAdminUsers()
    {
        $title = 'Pixel Plush - Admin Users';
        $myView = new View('admin-users');
    }
    public function showAdminCategory()
    {
        $title = 'Pixel Plush - Admin Catégories';
        $myView = new View('admin-sub-category');
        $myView->setVars(['title' => $title]);
        $myView->render();
    }
}
