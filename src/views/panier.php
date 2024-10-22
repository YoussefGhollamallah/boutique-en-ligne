<?php

$panierController = new PanierController();
$panier = $panierController->afficherPanier();
?>

<h3>Votre Panier</h3>
<section class="section">
    <?php if (!empty($panier)) { ?>
        <?php foreach ($panier as $idProduit => $produit) { ?>
            <div class="card_produit">
                <img class="card_produit_img" src="assets/images/<?php echo htmlspecialchars($produit['image']); ?>" alt="<?php echo htmlspecialchars($produit['nom']); ?>">
                <h4><input type="checkbox"><?php echo htmlspecialchars($produit['nom']); ?></h4>
                <p><?php echo htmlspecialchars($produit['description']); ?></p>
                <p>Prix unitaire : <?php echo htmlspecialchars($produit['prix']); ?> €</p>
                <p>Quantité : <input type="number"<?php echo htmlspecialchars($produit['quantite']); ?>></p>
                <p>Total : <?php echo htmlspecialchars($produit['prix'] * $produit['quantite']); ?> €</p>
            </div>
        <?php } ?>
    <?php } else { ?>
        <p>Votre panier est vide.</p>
    <?php } ?>
</section>
