<?php

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $produitController = new ProduitController();
    $idProduit = $_GET['id'];

    // Récupère les informations du produit correspondant
    $produit = $produitController->getProductById($idProduit);

    if ($produit) {
        // Remplace les underscores par des espaces et met la première lettre de chaque mot en majuscule
        $nomProduit = ucwords(str_replace('_', ' ', $produit['nom']));
    } else {
        echo "Produit non trouvé.";
        exit();
    }
} else {
    echo "ID de produit non valide.";
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
    <section class="section_detail">
        <h2>Détails du produit</h2>

        <div class="product_detail_container">
            <img src="../assets/images/<?php echo $produit['image']; ?>" alt="<?php echo $nomProduit; ?>" class="product_detail_img">

            <div class="product_detail_info">
                <h3><?php echo $nomProduit; ?></h3>
                <p><strong>Prix : </strong><?php echo $produit['prix']; ?> €</p>
                <p><strong>Description : </strong><?php echo $produit['description']; ?></p>
                <p><strong>Quantité disponible : </strong><?php echo $produit['quantite']; ?></p>

                <a href="panier.php?action=ajouter&id=<?php echo $produit['id']; ?>" class="btn btn-ajouter">Ajouter au panier</a>
            </div>
        </div>
    </section>
</body>
</html>
