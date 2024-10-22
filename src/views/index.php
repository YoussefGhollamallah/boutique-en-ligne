<?php

$produitController = new ProduitController();
$products = $produitController->getAllProducts();

?>

<section class="section_phare">
    <h3>Produits phares</h3>
    <article class="article_phare flex space-around carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="product-details">
                    <img src="<?php echo ASSETS; ?>/images/placeholder.png" alt="Produit 1">
                    <div class="carousel-caption">
                        <h5>
                            Produit 1
                        </h5>
                        <p>
                            Peluche représentant Izuku Midoriya (Deku), l'apprenti héros de My Hero Academia, dans son costume vert.
                        </p>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="product-details">
                        <img src="./assets/images/placeholder.png" alt="Produit 1">
                        <div class="carousel-caption">
                            <h5>
                            </h5>
                            <p>
                            </p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="product-details">
                            <img src="./assets/images/placeholder.png" alt="Produit 3">
                            <div class="carousel-caption">
                                <h5>
                                </h5>
                                <p>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselPharePrev" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                </a>
                <a class="carousel-control-next" href="#carouselPhareNext" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                </a>
                <a href="#carouselPhareDetail" class="carousel-control-product"></a>
    </article>
</section>
<section class="section_categorie   flex column ">
    <h3 id="title_categorie" class="text-center">Catégorie</h3>
    <article class="flex flex-wrap article_categorie space-around">
        <a href="#" class="card_categorie flex-column">
            <img src="assets/images/jeux_videos.png" class="" alt="Catégorie jeux video">
        </a>
        <a href="#" class="card_categorie flex-column">
            <img src="assets/images/films_&_series.png" class="" alt="Catégorie Films et Séries">
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
            <div class="card_produit">
                <img class="card_produit_img" src="assets/images/<?php echo $produit['image']; ?>" alt="Peluche de <?php echo $nomProduit ?> ">
                <h4><?php echo $nomProduit ?></h4>
                <p><?php echo $produit['prix']; ?> €</p>
                <button class="btn-ajouter-panier" data-id="<?= $produit['id']; ?>">Ajouter au panier</button>
            </div>
        <?php
        }
        ?>
    </article>
</section>

<script>
document.querySelectorAll('.btn-ajouter-panier').forEach(button => {
    button.addEventListener('click', function() {
        const idProduit = this.getAttribute('data-id');
        const quantite = this.previousElementSibling.value;

        fetch('index.php?action=ajouterProduitAuPanier', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: idProduit, quantite: quantite })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert('Produit ajouté au panier');
            }
        })
        .catch(error => console.error('Erreur:', error));
    });
});
</script>