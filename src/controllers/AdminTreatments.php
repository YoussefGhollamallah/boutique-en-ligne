<?php
require_once('../models/db.php');
require_once('../models/ModelCategory.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection
$bdd = connexionBDD();

$query = "SELECT id_SousCategorie, nom_sc FROM SousCategorie";
$stmt = $bdd->prepare($query);
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC); 

if (!empty($_POST['Form'])) {
    $nom = trim($_POST['nom']);
    $desc = trim($_POST['desc']);

    if (strlen($nom) > 0) {
        $categoryModel = new CategoryModel();

        // Check if category already exists
        $query = "SELECT COUNT(*) as count FROM SousCategorie WHERE nom_sc = :nom";
        $stmt = $bdd->prepare($query);
        $stmt->bindParam(':nom', $nom);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row['count'] > 0) {
            echo "This category already exists!";
        } else {
            $categoryModel->AddCat($nom, $desc);
            echo "Category added successfully!";
        }
    } else {
        echo "Please provide a category name.";
    }
} else {
    echo "No POST data received.";
}

// Hidden form processing
if (!empty($_POST['HiddenForm'])) {
    $hiddenName = trim($_POST['newName']);
    $hiddenDesc = trim($_POST['descHidden']);
    $dropdown = $_POST['cible'];

    if (strlen($hiddenName) > 0) {
        $cat = new CategoryModel();

        foreach ($dropdown as $selectedCible) {
            // Modify the category with the selected cible (category ID)
            $cat->ModifyCat($hiddenName, $hiddenDesc, $selectedCible);
        }
    }
}
?>
