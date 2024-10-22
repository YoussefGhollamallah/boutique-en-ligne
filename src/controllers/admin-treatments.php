<?php
require_once('../models/db.php');
require_once('../models/ModelCategory.php'); 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$bdd = connexionBDD();

if (!empty($_POST)) {
    $nom = trim($_POST['nom']); 
    $desc = trim($_POST['desc']);

    if (strlen($nom) > 0) {
        $categoryModel = new CategoryModel();

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
?>