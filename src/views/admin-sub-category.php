<?php
include_once(__DIR__ . "/../../include/_head.php");
include_once(__DIR__ . "/../../include/_header.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../assets/css/admin.css"> <!-- Link to the external CSS file -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion</title>
</head>
<body>
    <form id="categoryForm" action="../controllers/admin-treatments.php" method="post" enctype="multipart/form-data">
        <section class="container">
            <section class="section">
                <img class="logo" src="../../assets/images/logo.png" alt="">
                <label for="categories">Nom de Categories</label>
                <input type="text" id="categories" placeholder="Name" name="nom">
            </section>
            <section class="section">
                <textarea name="desc" id="desc" rows="4" placeholder="Description"></textarea>
            </section>
            <input type="submit" class="btn btn-ajouter" value="Valider">
        </section>
    </form>
    <script src="../../assets/js/admin.js"></script>
</body>
</html>
