<?php

class CategoryController
{
    private $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
    }

    public function handleRequest()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['nom'], $_POST['desc'])) {
                $nom = trim($_POST['nom']);
                $desc = trim($_POST['desc']);
                echo $this->AddCat($nom, $desc);
                return;
            }

            if (isset($_POST['newName'], $_POST['descHidden'], $_POST['cible'])) {
                $hiddenName = trim($_POST['newName']);
                $hiddenDesc = trim($_POST['descHidden']);
                $dropdown = $_POST['cible'];

                echo $this->ModifyCat($hiddenName, $hiddenDesc, $dropdown);
                return;
            }

            if (isset($_POST['sup'])) {
                echo $this->Delete($_POST['sup']);
                return;
            }
        }
    }

    public function AddCat($nom, $desc)
    {
        if (empty(trim($nom))) {
            return "Veuillez fournir un nom de catégorie.";
        }

        $categories = $this->categoryModel->getCategories();
        foreach ($categories as $category) {
            if ($category['nom_sc'] === $nom) {
                return "Cette catégorie existe déjà !";
            }
        }

        try {
            $this->categoryModel->AddCat($nom, $desc);
            return "Catégorie ajoutée avec succès !";
        } catch (Exception $e) {
            return "Erreur lors de l'ajout de la catégorie : " . $e->getMessage();
        }
    }

    public function ModifyCat($nom, $description, $ids)
    {
        if (empty(trim($nom))) {
            return "Veuillez fournir un nom de catégorie.";
        }

        try {
            foreach ($ids as $id) {
                $this->categoryModel->ModifyCat($nom, $description, $id);
            }
            return "Modification réussie.";
        } catch (Exception $e) {
            return "Erreur lors de la modification de la catégorie : " . $e->getMessage();
        }
    }

    public function Delete($id)
    {
        try {
            $this->categoryModel->Delete($id);
            return "Catégorie supprimée avec succès.";
        } catch (Exception $e) {
            return "Erreur lors de la suppression de la catégorie : " . $e->getMessage();
        }
    }

    public function listCategories()
    {
        return $this->categoryModel->getCategories();
    }
}

$controller = new CategoryController();
$controller->handleRequest();
?>