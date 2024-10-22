<?php
session_start();

// Récupération de tous les produits
$produitController = new ProduitController();
$products = $produitController->getAllProducts();

// Vérifie si un produit doit être ajouté au panier
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'ajouterProduitAuPanier') {
    $panierController = new PanierController();
    $idProduit = intval($_POST['id']);
    $quantite = intval($_POST['quantite']);
    $panierController->ajouterProduitAuPanier($idProduit, $quantite);
}
?>

<!-- Section des produits phares -->
<section class="section_phare">
    <h3>Produits phares</h3>
    <article class="article_phare flex space-around carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="product-details">
                    <img src="assets/images/placeholder.png" alt="Produit 1">
                    <div class="carousel-caption">
                        <h5>Produit 1</h5>
                        <p>Description du produit 1</p>
                    </div>
                </div>
            </div>
            <!-- Ajoutez d'autres items de carousel si nécessaire -->
        </div>
        <a class="carousel-control-prev" href="#carouselPharePrev" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </a>
        <a class="carousel-control-next" href="#carouselPhareNext" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </a>
    </article>
</section>

<!-- Section des catégories -->
<section class="section_categorie flex column">
    <h3 id="title_categorie" class="text-center">Catégorie</h3>
    <article class="flex flex-wrap article_categorie space-around">
        <a href="#" class="card_categorie flex-column">
            <img src="assets/images/jeux_videos.png" alt="Catégorie jeux vidéo">
        </a>
        <a href="#" class="card_categorie flex-column">
            <img src="assets/images/films_&_series.png" alt="Catégorie Films et Séries">
        </a>
    </article>
</section>

<!-- Section des produits -->
<section class="section_products">
    <h3 id="title_produits">Produits</h3>
    <article class="article_produit flex space-around flex-wrap">
        <?php
        foreach ($products as $produit) {
            $nomProduit = ucwords(str_replace('_', ' ', $produit['nom']));
        ?>
            <div class="card_produit">
                <img class="card_produit_img" src="assets/images/<?php echo htmlspecialchars($produit['image']); ?>" alt="<?php echo htmlspecialchars($nomProduit); ?>">
                <h4><?php echo htmlspecialchars($nomProduit); ?></h4>
                <p><?php echo htmlspecialchars($produit['prix']); ?> €</p>
                <form method="POST" action="index">
                    <input type="hidden" name="id" value="<?php echo intval($produit['id']); ?>">
                    <input type="hidden" name="action" value="ajouterProduitAuPanier">
                    <input type="number" name="quantite" value="1" min="1" style="width: 60px;">
                    <input type="submit" value="Ajouter au panier">
                </form>
            </div>
        <?php
        }
        ?>
    </article>
</section>
