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
            <div class="carousel-item active">
                <div class="product-details">
                    <img src="<?php echo ASSETS;?>/images/placeholder.png" alt="Produit 1">
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

<script>
document.querySelectorAll('.form-ajouter-panier').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);

        fetch('', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            document.getElementById('confirmation-message').textContent = data;
            const popup = document.getElementById('confirmation-popup');
            popup.style.display = 'block';
            setTimeout(() => {
                popup.style.display = 'none';
            }, 3000);
        })
        .catch(error => console.error('Erreur:', error));
    });
});
</script>