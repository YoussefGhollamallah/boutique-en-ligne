<?php
// Path: src/views/categorie.php

include 'src/controllers/CategorieController.php';

$categorieController = new CategorieController();
$categories = $categorieController->getAllCategorie();
?>

<h1>Produits par Catégorie</h1>

<div id="categorie-container">
    <?php foreach ($categories as $categorie): ?>
        <?php $nomCategorie = ucwords(str_replace('_', ' ', $categorie['nom_p'])); ?>
        <div class="card_categorie box_shadow flex-column">
            <button class="categorie-button" data-categorie-id="<?php echo $categorie['id_categorie']; ?>">
                <?php echo $nomCategorie; ?>
            </button>
            <img src="assets/images/<?php echo ($categorie['nom_p'] == 'Films et Séries') ? 'films_&_series.png' : 'jeux_videos.png'; ?>" alt="Catégorie <?php echo $nomCategorie; ?>">
        </div>
    <?php endforeach; ?>
</div>

<div id="produit-container">
    <!-- Les produits seront affichés ici selon la catégorie sélectionnée -->
</div>

<script src="assets/js/fetchProducts.js"></script>
