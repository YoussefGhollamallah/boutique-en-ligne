<?php

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $produitController = new ProduitController();
    $idProduit = $_GET['id'];

    $produit = $produitController->getProductById($idProduit);

    if ($produit) {
        $nomProduit = ucwords(str_replace('_', ' ', $produit['nom']));
    } else {
        // Si le produit n'existe pas, on redirige vers la page d'accueil
        header('Location: ../index.php');
        exit();
    }
} else {
    // Si l'id n'est pas défini ou n'est pas un nombre, on redirige vers la page d'accueil
    header('Location: ../index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détail du produit</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <section class="section_detail flex ">
        <img class="card_produit_img card_produit_img_detail box-shadow" src="../assets/images/<?php echo $produit['image']; ?>" alt="<?php echo $nomProduit; ?>" class="product_detail_img">
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
                <a href="panier.php?action=ajouter&id=<?php echo $produit['id']; ?>" class="btn btn-ajouter">Ajouter au panier</a>
            </div>
        </article>
    </section>
    <script src="../assets/js/detail.js"></script>
</body>

</html>