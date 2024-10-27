<?php
// Classe Routeur qui gère les routes et appelle les controllers
class Routeur
{
    private $request;
    
    // Tableau de correspondance entre les routes et les controllers
    private $routes = [ 
        "index"      => ["controller" => 'HomeController', "method" => 'showHome'], 
        "panier"     => ["controller" => 'HomeController', "method" => 'showPanier'],
        "page404"    => ["controller" => 'HomeController', "method" => 'show404'],
        "categories" => ["controller" => 'HomeController', "method" => 'showCategories'],
        "profil"     => ["controller" => 'HomeController', "method" => 'showProfil'],
        "connexion"  => ["controller" => 'HomeController', "method" => 'showConnexion'],
        "verification" => ["controller" => 'HomeController', "method" => 'showVerification'],
        "detail"     => ["controller" => 'HomeController', "method" => 'showDetail'],
        "admin-produits"     => ["controller" => 'HomeController', "method" => 'showAdminProduits'],
        "admin-users" => ["controller" => 'HomeController', "method" => 'showAdminUsers'],
        "admin-sub-category"     => ["controller" => 'HomeController', "method" => 'showAdminCategory'],
     ];

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function renderController()
    {
        $request = $this->request;

        // Vérifie si la requête (URL) existe dans les routes
        if (array_key_exists($request, $this->routes)) {
            // Récupère le contrôleur et la méthode associés à la route
            $controller = $this->routes[$request]['controller'];
            $method     = $this->routes[$request]['method'];

            // Vérifie si le contrôleur existe avant de l'instancier
            if (class_exists($controller)) {
                $currentController = new $controller();
                // Vérifie si la méthode existe dans le contrôleur
                if (method_exists($currentController, $method)) {
                    $currentController->$method();
                } else {
                    // Si la méthode n'existe pas, redirige vers la page 404
                    $this->redirect404();
                }
            } else {
                // Si le contrôleur n'existe pas, redirige vers la page 404
                $this->redirect404();
            }
        } else {
            // Si la route n'existe pas, redirige vers la page 404
            $this->redirect404();
        }
    }

    // Méthode pour rediriger vers la page 404
    private function redirect404()
    {
        // Redirige vers le contrôleur qui gère la page 404
        $controller = $this->routes['page404']['controller'];
        $method = $this->routes['page404']['method'];

        $currentController = new $controller();
        $currentController->$method();
    }
    
}
