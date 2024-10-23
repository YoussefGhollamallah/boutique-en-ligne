<?php
require_once('../models/db.php');
require_once('../models/ModelCategory.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Connexion à la base de données
$bdd = connexionBDD();

$categoryModel = new CategoryModel();
$categories = $categoryModel->getCategories();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['nom'], $_POST['desc'])) {
        $nom = trim($_POST['nom']);
        $desc = trim($_POST['desc']);

        if (!empty($nom)) {
            // Vérification de l'existence de la catégorie
            $query = "SELECT COUNT(*) as count FROM SousCategorie WHERE nom_sc = :nom";
            $stmt = $bdd->prepare($query);
            $stmt->bindParam(':nom', $nom);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row['count'] > 0) {
                echo "Cette catégorie existe déjà !";
            } else {
                $categoryModel->AddCat($nom, $desc);
                echo "Catégorie ajoutée avec succès !";
            }
        } else {
            echo "Veuillez fournir un nom de catégorie.";
        }
    }

    if (isset($_POST['newName'], $_POST['descHidden'], $_POST['cible'])) {
        $hiddenName = trim($_POST['newName']);
        $hiddenDesc = trim($_POST['descHidden']);
        $dropdown = $_POST['cible'];

        if (!empty($hiddenName) && !empty($dropdown)) {
            foreach ($dropdown as $selectedCible) {
                $categoryModel->ModifyCat($hiddenName, $hiddenDesc, $selectedCible);
            }
            echo "Modification réussie.";
        } else {
            echo "Veuillez sélectionner une catégorie et fournir un nouveau nom.";
        }
    }
}
?>
