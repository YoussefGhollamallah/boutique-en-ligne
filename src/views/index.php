<?php
include 'src/controllers/ProduitController.php';

$produitController = new ProduitController();
$products = $produitController->getAllProducts();
$lastThreeProducts = $produitController->getLastThreeProducts();

?>


<section class="section_phare">
    <h3>Produits phares</h3>
    <article class="article_phare flex space-around carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <?php
            $isActive = true;
            foreach ($lastThreeProducts as $produit) {
                $nomProduit = ucwords(str_replace('_', ' ', $produit['nom']));
                $activeClass = $isActive ? 'active' : '';
                $isActive = false;
            ?>
                <a href="./detail/<?php echo $produit['id'] ?>">
                    <div class="carousel-item <?php echo $activeClass; ?>">
                        <div class="product-details">
                            <img src="assets/images/<?php echo $produit['image']; ?>" alt="Peluche de <?php echo $nomProduit; ?>">
                            <div class="carousel-caption">
                                <h5><?php echo $nomProduit; ?></h5>
                                <p><?php echo $produit['description']; ?></p>
                            </div>
                        </div>
                    </div>
                </a>
            <?php
            }
            ?>
        </div>
        <a class="carousel-control-prev" href="#carouselPharePrev" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </a>
        <a class="carousel-control-next" href="#carouselPhareNext" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </a>
    </article>
</section>
<section class="section_categorie   flex column ">
    <h3 id="title_categorie" class="text-center">Catégorie</h3>
    <article class="flex flex-wrap article_categorie space-around">
        <a href="#" class="card_categorie box_shadow flex-column">
            <img src="assets/images/jeux_videos.png" alt="Catégorie jeux video">
        </a>
        <a href="#" class="card_categorie box_shadow flex-column">
            <img src="assets/images/films_&_series.png" alt="Catégorie Films et Séries">
        </a>
    </article>
</section>
<section class="section_products">
    <h3 id="title_produits">Produits</h3>
    <article class="article_produit flex space-around flex-wrap">
        <?php
        foreach ($products as $produit) {
            $nomProduit = ucwords(str_replace('_', ' ', $produit['nom']));
        ?>
            <a href="./detail/<?php echo $produit['id'] ?>">
                <div class="card_produit box-shadow">
                    <img class="card_produit_img" src="assets/images/<?php echo $produit['image']; ?>" alt="Peluche de <?php echo $nomProduit ?> ">
                    <h4><?php echo $nomProduit ?></h4>
                    <p><?php echo $produit['prix']; ?> €</p>
                    <button class="btn btn-ajouter" onclick="event.stopPropagation();">Ajouter au panier</button>
                </div>
            </a>
        <?php
        }
        ?>
    </article>
</section>
<script src="assets/js/carousel.js"></script>