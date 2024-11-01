<?php
session_start();

// Récupération de tous les produits
$produitController = new ProduitController();
$products = $produitController->getAllProducts();
$lastThreeProducts = $produitController->getLastThreeProducts();

// Vérifie si un produit doit être ajouté au panier
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'ajouterProduitAuPanier') {
    $panierController = new PanierController();
    $idProduit = intval($_POST['id']);

    // Vérifie si l'ID du produit est valide
    if ($idProduit > 0) {
        $panierController->ajouterProduitAuPanier($idProduit, 1); // Quantité fixée à 1 pour l'index
        echo json_encode(['success' => true, 'message' => "Le produit a bien été ajouté au panier."]);
    } else {
        echo json_encode(['success' => false, 'message' => "Erreur : ID produit invalide."]);
    }
    exit; // Terminer le script après avoir traité la requête AJAX
}

// Vérifie si un filtre de catégorie est appliqué
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['categorieId'])) {
    $categorieId = intval($_GET['categorieId']);
    $produitController = new ProduitController();
    $filteredProducts = $produitController->getProductsByCategory($categorieId);
    echo json_encode($filteredProducts); // Retourne le JSON pour JavaScript
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


<!-- Liste produits -->
<section class="section_products">
    <h3 id="title_produits">Produits</h3>
    <article class="article_produit flex space-around flex-wrap" id="product-list">
        <?php
        foreach ($products as $produit) {
            $nomProduit = ucwords(str_replace('_', ' ', $produit['nom']));
        ?>
            <a href="<?php echo BASE_URL; ?>detail/<?php echo intval($produit['id']); ?>">
                <div class="card_produit box-shadow">
                    <img class="card_produit_img" src="<?php echo ASSETS; ?>/images/<?php echo htmlspecialchars($produit['image']); ?>" alt="<?php echo htmlspecialchars($nomProduit); ?>">
                    <h4><?php echo htmlspecialchars($nomProduit); ?></h4>
                    <p class="prix-produit"><?php echo htmlspecialchars($produit['prix']); ?> €</p>
                    <form class="form-ajouter-panier" method="POST" action="">
                        <input type="hidden" name="id" value="<?php echo intval($produit['id']); ?>">
                        <input type="hidden" name="action" value="ajouterProduitAuPanier">
                        <button class="btn btn-ajouter" type="submit" onclick="ajouterAuPanier(event, <?php echo intval($produit['id']); ?>)">Ajouter au panier</button>
                    </form>
                </div>
            </a>
        <?php
        }
        ?>
    </article>
</section>

<div id="confirmation-popup" style="display: none; position: fixed; top: 20px; right: 20px; background-color: #4CAF50; color: white; padding: 10px; border-radius: 20px; z-index: 100;">
    <p id="confirmation-message"></p>
</div>

<script>
    const BASE_URL = "<?php echo BASE_URL; ?>";
    const ASSETS = "<?php echo ASSETS; ?>";
    const pageURL = "<?php echo $_SERVER['PHP_SELF']; ?>";

    // POUR L'AJOUT AU PANIER
    function ajouterAuPanier(event, productId) {
        event.preventDefault(); // Empêcher la soumission normale du formulaire

        if (productId <= 0) {
            alert("Erreur : ID produit invalide.");
            return;
        }

        const formData = new FormData();
        formData.append('id', productId);
        formData.append('action', 'ajouterProduitAuPanier');

        fetch(pageURL, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                const popup = document.getElementById('confirmation-popup');
                const messageElement = document.getElementById('confirmation-message');
                messageElement.innerText = data.message;
                popup.style.display = 'block';
                setTimeout(() => {
                    popup.style.display = 'none';
                }, 3000); // Masquer le message après 3 secondes
            })
            .catch(error => {
                console.error('Erreur:', error);
            });
    }
</script>