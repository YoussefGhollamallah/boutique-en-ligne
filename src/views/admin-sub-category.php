<?php 
//include('../models/ModelCategory.php');

$cat = new CategoryModel();

$result = $cat->getCategories();



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
<head>
<link rel="stylesheet" href="<?php echo ASSETS; ?>css/admin.css">
</head>

<form class="Form" id="categoryForm" action="" method="post">
    <section class="container">
        <section class="section">
            <button id="modify" type="button">Modifier</button>
            <img class="logo" src="<?php echo ASSETS;?>/images/logo.png" alt="">
            <label for="categories">Nom de la Catégorie</label>
            <input type="text" id="nom" placeholder="Name" name="nom">
        </section>
        <section class="section">
            <textarea name="desc" id="desc" rows="4" placeholder="Description"></textarea>
        </section>
        <input type="submit" class="btn btn-ajouter" value="Valider">
    </section>
</form>

<form class="HiddenForm" id="hiddenForm" action="" method="post" style="display: none;">
    <section class="container">
        <section class="section">
            <button id="Add" type="button">Ajouter</button>
            <img class="logo" src="../../assets/images/logo_etabli.png" alt="">
            <label for="newName">Nouveau Nom de la Catégorie</label>
            <input type="text" id="newName" placeholder="Name" name="newName">
        </section>
        <section class="section">
            <textarea name="descHidden" id="descHidden" rows="4" placeholder="Description"></textarea>
        </section>
        <label for="cible">Catégories</label>
        <select id="cible" name="cible[]" multiple size="5">
            <?php
            echo $categories;
            // Affichage des catégories
            if (!empty($result)) {
                foreach ($result as $category) {
                    echo '<option value="' . htmlspecialchars($category['id_sousCategorie']) . '">' . htmlspecialchars($category['nom_sc']) . '</option>';
                }
            } else {
                echo '<option disabled>Aucune catégorie disponible</option>';
            }
            ?>
        </select>
        <input type="submit" class="btn-Modifier" value="Modifier">

        <label for="sup">Supprimer</label>
        <select id="sup" name="sup" multiple size="5">
            <?php
            if (!empty($result)) {
                foreach ($result as $category) {
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

<script src="<?php echo ASSETS;?>/js/admin.js"></script>
</body>
</html>