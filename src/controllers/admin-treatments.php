<?php
require_once('../models/db.php');
require_once('../models/model-category.php'); // Adjusted path

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Connect to the database
$bdd = connexionBDD();

if (!empty($_POST)) {
    $nom = trim($_POST['nom']); // Use trim to avoid unnecessary spaces
    $desc = trim($_POST['desc']);
    var_dump($_POST);

    if (strlen($nom) > 0) {
        $categoryModel = new CategoryModel();

        $query = "SELECT COUNT(*) as count FROM SousCategorie WHERE nom_sc = :nom";
        $stmt = $bdd->prepare($query);
        $stmt->bindParam(':nom', $nom);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row['count'] > 0) {
            // If a category with the same name exists, show a message
            echo "This category already exists!";
            header('Location: ../views/admin-sub-category.php?error=duplicate');
            exit;
        } else {
            // If no duplicate, proceed to add the category
            $categoryModel->AddCat($nom, $desc);
            echo "Category added successfully!";
            header('Location: ../views/admin-sub-category.php?success=true');
            exit;
        }
    } else {
        echo "Please provide a category name.";
        header('Location: ../views/admin-sub-category.php?error=empty');
        exit;
    }
}
?>
