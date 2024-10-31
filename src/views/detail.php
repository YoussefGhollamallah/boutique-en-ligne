<?php
session_start();

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $produitController = new ProduitController();
    $idProduit = $_GET['id'];
    $produit = $produitController->getProductById($idProduit);

    if ($produit) {
        $nomProduit = ucwords(str_replace('_', ' ', $produit['nom']));
        $title = "Pixel Plush - " . $nomProduit; // Définit le titre de la page
    } else {
        header('Location: index');
        exit();
    }
} else {
    header('Location: index');
    exit();
}

// Vérifie si un produit doit être ajouté au panier
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action']) && $_POST['action'] == 'ajouterProduitAuPanier') {
        $panierController = new PanierController();
        $idProduit = intval($_POST['id']);
        $quantite = isset($_POST['quantite']) ? intval($_POST['quantite']) : 1; // Récupère la quantité

        if ($quantite > 0) {
            $panierController->ajouterProduitAuPanier($idProduit, $quantite);
            echo 'Le produit a bien été ajouté au panier.';
        } else {
            echo 'La quantité doit être supérieure à zéro.';
        }
        exit;
    }
}
?>

<section class="section_detail flex">
    <img class="card_produit_img card_produit_img_detail box-shadow" src="<?php echo ASSETS; ?>/images/<?php echo $produit['image']; ?>" alt="<?php echo $nomProduit; ?>" class="product_detail_img">
    <article class="article_detail flex column justify-between">
        <div class="description">
            <h3><?php echo $nomProduit; ?></h3>
            <p><strong>Description : </strong><?php echo $produit['description']; ?></p>
        </div>
        <div class="detail_buying">
            <div>
                <p><strong>Prix :</strong> <?php echo $produit['prix']; ?> €</p>
                <div class="quantity-container">
                    <label id="label_quantity" for="quantite"><strong>Quantité :</strong></label>
                    <input class="input_quantite" type="number" name="quantite" id="quantite" value="1" min="1" max="<?php echo $produit['quantite']; ?>">
                    <div class="flex-no-wrap">
                        <button type="button" onclick="changeQuantity(-1)">-</button>
                        <button type="button" onclick="changeQuantity(1)">+</button>
                    </div>
                </div>
            </div>
            <form class="form-ajouter-panier" method="POST" action="">
                <input type="hidden" name="id" value="<?php echo intval($produit['id']); ?>">
                <input type="hidden" name="action" value="ajouterProduitAuPanier">
                <input type="hidden" name="quantite" id="hidden-quantite" value="1">
                <button class="btn btn-ajouter" type="submit">Ajouter au panier</button>
            </form>
        </div>
    </article>
</section>
<div id="confirmation-popup" style="display: none; position: fixed; top: 20px; right: 20px; background-color: #4CAF50; color: white; padding: 10px; border-radius: 20px; z-index: 100;">
    <p id="confirmation-message"></p>
</div>

<script>
    document.querySelector('.form-ajouter-panier').addEventListener('submit', function(e) {
        e.preventDefault(); // Empêche le rechargement de la page

        const quantityInput = document.getElementById('quantite').value;
        document.getElementById('hidden-quantite').value = quantityInput; // Assure que la quantité est bien envoyée

        const formData = new FormData(this);

        fetch(this.action, {
            method: this.method,
            body: formData
        })
        .then(response => response.json()) // Attendre une réponse JSON du serveur
        .then(data => {
            const popup = document.getElementById('confirmation-popup');
            const message = document.getElementById('confirmation-message');
            message.textContent = data.message; // Affiche le message
            popup.style.display = 'block';
            setTimeout(() => popup.style.display = 'none', 3000);
        })
        .catch(error => console.error('Erreur:', error));
    });

    // Fonction pour changer la quantité
    function changeQuantity(amount) {
        const quantityInput = document.getElementById('quantite');
        let newQuantity = parseInt(quantityInput.value) + amount;
        if (newQuantity < 1) newQuantity = 1; // Ne permet pas de quantité inférieure à 1
        quantityInput.value = newQuantity;
        document.getElementById('hidden-quantite').value = newQuantity; // Mettez à jour la quantité cachée pour le formulaire
    }
</script>
