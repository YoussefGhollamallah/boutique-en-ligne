<?php
session_start();

// Récupération de tous les produits
$produitController = new ProduitController();
$products = $produitController->getAllProducts();
$lastThreeProducts = $produitController->getLastThreeProducts();

// Vérifie si un produit doit être ajouté au panier
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action']) && $_POST['action'] == 'ajouterProduitAuPanier') {
        $panierController = new PanierController();
        $idProduit = intval($_POST['id']);
        $panierController->ajouterProduitAuPanier($idProduit, 1); // Quantité fixée à 1
        echo "Le produit a bien été ajouté au panier.";
        exit;
    }
}
?>

<!-- Section des produits phares -->
<section class="section_phare">
    <h3>Nos Nouveautés</h3>
    <article class="article_phare flex space-around carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <?php
            $isActive = true;
            foreach ($lastThreeProducts as $produit) {
                $nomProduit = ucwords(str_replace('_', ' ', $produit['nom']));
                $activeClass = $isActive ? 'active' : '';
                $isActive = false;
            ?>
            <div class="carousel-item active">
                <div class="product-details">
                    <img src="<?php echo ASSETS;?>/images/<?php echo $nomProduit ?>.png" alt="<?php echo $nomProduit ?>">
                    <div class="carousel-caption">
                        <h3><?php echo $nomProduit ?></h3>
                        <p><?php echo $produit['prix'] ?> €</p>
                        <form class="form-ajouter-panier" method="POST" action="">
                            <input type="hidden" name="id" value="<?php echo intval($produit['id']); ?>">
                            <input type="hidden" name="action" value="ajouterProduitAuPanier">
                            <button class="btn btn-ajouter" type="submit">Ajouter au panier</button>
                        </form>
                    </div>
                </div>
            </div>
            <?php
        } ?>
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
<section class="section_categorie flex column ">
    <h3 id="title_categorie" class="text-center">Catégorie</h3>
    <article class="flex flex-wrap article_categorie space-around">
        <a href="<?php echo BASE_URL; ?>categories" class="card_categorie flex-column">
            <img src="<?php echo ASSETS;?>/images/jeux_videos.png" alt="Catégorie jeux vidéo">
        </a>
        <a href="<?php echo BASE_URL; ?>categories"  class="card_categorie flex-column">
            <img src="<?php echo ASSETS;?>/images/films_&_series.png" alt="Catégorie Films et Séries">
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
            <a href="<?php echo BASE_URL;?>detail/<?php echo intval($produit['id']); ?>"> <img class="card_produit_img" src="<?php echo ASSETS;?>/images/<?php echo htmlspecialchars($produit['image']); ?>" alt="<?php echo htmlspecialchars($nomProduit); ?>"></a>
                <h4><?php echo htmlspecialchars($nomProduit); ?></h4>
                <p><?php echo htmlspecialchars($produit['prix']); ?> €</p>
                <form class="form-ajouter-panier" method="POST" action="">
                    <input type="hidden" name="id" value="<?php echo intval($produit['id']); ?>">
                    <input type="hidden" name="action" value="ajouterProduitAuPanier">
                    <button class="btn btn-ajouter" type="submit">Ajouter au panier</button>
                </form>
            </div>
        <?php
        }
        ?>
    </article>
</section>

<div id="confirmation-popup" style="display: none; position: fixed; top: 20px; right: 20px; background-color: #4CAF50; color: white; padding: 10px; border-radius: 20px;">
    <p id="confirmation-message"></p>
</div>

<script src="<?php echo ASSETS;?>js/carousel.js"></script>