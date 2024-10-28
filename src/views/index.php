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

// Gérer la requête AJAX pour récupérer les produits par catégorie
if (isset($_GET['categorieId'])) {
    $categorieController = new CategorieController();
    $categorieId = intval($_GET['categorieId']);
    $produitsByCategorie = $categorieController->getAllProductsBycategorie($categorieId);
    echo json_encode($produitsByCategorie);
    exit;
}
?>

<!-- Section des produits phares -->
<section class="section_phare">
    <h3>Nos Nouveautés</h3>
    <article class="article_phare flex space-around carousel slide box-shadow" data-ride="carousel">
        <div class="carousel-inner">
            <?php
            $isActive = true;
            foreach ($lastThreeProducts as $produit) {
                $nomProduit = ucwords(str_replace('_', ' ', $produit['nom']));
                $activeClass = $isActive ? 'active' : '';
                $isActive = false;
            ?>
                <a class="box-shadow" href="./detail/<?php echo $produit['id'] ?>">
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

<section class="section_categorie flex column">
    <h3 id="title_categorie" class="text-center">Catégorie</h3>
    <article class="flex align-center flex-wrap article_categorie space-around ">
        <a class="card_categorie box-shadow" onclick="filterProducts(1)">
            <img src="<?php echo ASSETS ?>images/jeux_videos.png" alt="Jeux Vidéos">
        </a>
        <a class="card_categorie box-shadow" onclick="filterProducts(2)">
            <img src="<?php echo ASSETS ?>images/films_&_series.png" alt="Films et Séries">
        </a>
        <section id="sous-categories-container" style="display:none;">
            <div id="sous-categories-list" class="flex flex-wrap"></div>
        </section>

    </article>
</section>

<section class="section_products">
    <h3 id="title_produits">Produits</h3>
    <article class="article_produit flex space-around flex-wrap" id="product-list">
        <?php
        // Afficher tous les produits au départ
        foreach ($products as $produit) {
            $nomProduit = ucwords(str_replace('_', ' ', $produit['nom']));
        ?>
            <a href="<?php echo BASE_URL; ?>detail/<?php echo intval($produit['id']); ?>">
                <div class="card_produit box-shadow">
                    <img class="card_produit_img" src="<?php echo ASSETS; ?>/images/<?php echo htmlspecialchars($produit['image']); ?>" alt="<?php echo htmlspecialchars($nomProduit); ?>">
                    <h4><?php echo htmlspecialchars($nomProduit); ?></h4>
                    <p><?php echo htmlspecialchars($produit['prix']); ?> €</p>
                    <form class="form-ajouter-panier" method="POST" action="">
                        <input type="hidden" name="id" value="<?php echo intval($produit['id']); ?>">
                        <input type="hidden" name="action" value="ajouterProduitAuPanier">
                        <button class="btn btn-ajouter" type="submit">Ajouter au panier</button>
                    </form>
                </div>
            </a>
        <?php
        }
        ?>
    </article>
</section>

<div id="confirmation-popup" style="display: none; position: fixed; top: 20px; right: 20px; background-color: #4CAF50; color: white; padding: 10px; border-radius: 20px;">
    <p id="confirmation-message"></p>
</div>
<script>
    const BASE_URL = "<?php echo BASE_URL; ?>";
    const ASSETS = "<?php echo ASSETS; ?>";
    const pageURL = "<?php echo $_SERVER['PHP_SELF']; ?>";
</script>
<script src="<?php echo ASSETS; ?>js/filter.js"></script>


<script src="<?php echo ASSETS; ?>js/carousel.js"></script>