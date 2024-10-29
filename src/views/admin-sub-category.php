<?php 
// include('CatchThis.php');
include('../controllers/AdminTreatments.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user'])) {
    header('Location: connexion');
    exit;
}

if (isset($_SESSION["user"]["role_id"]) && $_SESSION["user"]["role_id"] != 1) {
    header('Location: index');
    exit;
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../assets/css/admin.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion</title>
</head>
<body>

<form class="Form" id="categoryForm" action="../controllers/AdminTreatments.php" method="post" enctype="multipart/form-data">
        <section class="container">
            <section class="section">
                <button id="modify" type="button">Modifier</button>
                <img class="logo" src="../../assets/images/logo.png" alt="">
                <label for="categories">Nom de Categories</label>
                <input type="text" id="nom" placeholder="Name" name="nom">
            </section>
            <section class="section">
                <textarea name="desc" id="desc" rows="4" placeholder="Description"></textarea>
            </section>
            <input type="submit" class="btn btn-ajouter" value="Valider">
        </section>
    </form>

   <!-- Formulaire caché pour la modification -->
<form class="HiddenForm" id="hiddenForm" action="../controllers/AdminTreatments.php" method="post" enctype="multipart/form-data" style="display: none;">
   
<section class="container">
        <section class="section">
            <button id="Add" type="button">Ajouter</button>
            <img class="logo" src="../../assets/images/logo_etabli.png" alt="">
            <label for="newName">Modifier le Nom</label>
            <input type="text" id="newName" placeholder="Name" name="newName">
        </section>
        <section class="section">
            <textarea name="descHidden" id="descHidden" rows="4" placeholder="Description"></textarea>
        </section>
        <label for="cible">Cible</label>
        <select id="cible" name="cible[]" multiple size="5">
            <?php
                var_dump($categories);
            // Affichage des catégories
            if (!empty($categories)) {
                foreach ($categories as $category) {
                    echo '<option value="' . htmlspecialchars($category['id_sousCategorie']) . '">' . htmlspecialchars($category['nom_sc']) . '</option>';
                }
            } else {
                echo '<option disabled>Aucune catégorie disponible</option>';
            }
            ?>
        </select>
        <input type="submit" class="btn-Modifier" value="Modifier">

        <!-- Sélection pour la suppression des catégories -->
        <label for="sup">Supprimer</label>
        <select id="sup" name="sup" multiple size="5">
            <?php
            if (!empty($categories)) {
                foreach ($categories as $category) {
                    echo '<option value="' . htmlspecialchars($category['id_sousCategorie']) . '">' . htmlspecialchars($category['nom_sc']) . '</option>';
                }
            } else {
                echo '<option disabled>Aucune catégorie disponible</option>';
            }
            ?>
        </select>
        <button id='delete' name='delete' type="submit">Supprimer</button>
    </section>
</form>

    <script src="../../assets/js/admin.js"></script>
</body>
</html>
