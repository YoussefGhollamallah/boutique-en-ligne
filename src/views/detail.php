<?php
session_start();

if (isset($_GET['id']) && is_numeric($_GET['id'])) 
{
    $produitController = new ProduitController();
    $idProduit = $_GET['id'];
    $produit = $produitController->getProductById($idProduit);

    if ($produit) 
    {
        $nomProduit = ucwords(str_replace('_', ' ', $produit['nom']));
        $title = "Pixel Plush - " . $nomProduit; // Définit le titre de la page
    } else 
    {
        header('Location: ../index.php');
        exit();
    }
} else 
{
    header('Location: ../index.php');
    exit();
}

// Vérifie si un produit doit être ajouté au panier
if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    if (isset($_POST['action']) && $_POST['action'] == 'ajouterProduitAuPanier') 
    {
        $panierController = new PanierController();
        $idProduit = intval($_POST['id']);
        // Vérification que 'quantite' est bien dans $_POST
        $quantite = isset($_POST['quantite']) ? intval($_POST['quantite']) : 1; // Valeur par défaut
        $panierController->ajouterProduitAuPanier($idProduit, $quantite);
        echo "Le produit a bien été ajouté au panier.";
        exit;
    }
}
?>

<section class="section_detail flex ">
    <img class="card_produit_img card_produit_img_detail box-shadow" src="<?php echo ASSETS;?>/images/<?php echo $produit['image']; ?>" alt="<?php echo $nomProduit; ?>" class="product_detail_img">
    <article class="article_detail flex column justify-between ">
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
                <button class="btn btn-ajouter" type="submit">Ajouter au panier</button>
            </form>
        </div>
    </article>
</section>
<div id="confirmation-popup" style="display: none; position: fixed; top: 20px; right: 20px; background-color: #4CAF50; color: white; padding: 10px; border-radius: 20px;">
    <p id="confirmation-message"></p>
</div>

<script>
document.querySelector('.form-ajouter-panier').addEventListener('submit', function(e) {
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

// Fonction pour changer la quantité
function changeQuantity(amount) {
    const quantiteInput = document.getElementById('quantite');
    let currentQuantity = parseInt(quantiteInput.value);
    currentQuantity += amount;
    
    // Vérification des limites
    if (currentQuantity < 1) {
        currentQuantity = 1;
    } else if (currentQuantity > parseInt(quantiteInput.max)) {
        currentQuantity = parseInt(quantiteInput.max);
    }
    
    quantiteInput.value = currentQuantity;
}
</script>


    <script src="<?php echo ASSETS;?>/js/detail.js"></script>
