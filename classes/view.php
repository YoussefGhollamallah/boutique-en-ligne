<?php

class View
{
    private $template;
    private $variables = [];

    public function __construct($template)
    {
        $this->template = $template;
    }

    // Méthode pour passer des variables à la vue
    public function setVars(array $variables)
    {
        $this->variables = $variables;
    }

    public function render() // Passer les variables dans les parenthèse pour afficher les objets
    {
        $template = $this->template;

        // Extraction des variables pour les rendre disponibles dans les vues
        extract($this->variables);

        ob_start();
        include(VIEW . $template . '.php');
        $contentPage = ob_get_clean();

        include_once(VIEW . 'layout.php');
    }
    
}
