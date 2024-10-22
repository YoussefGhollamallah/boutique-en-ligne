<main id="panier">
    <section class="section">
        <h2>Panier :</h2>
        <?php if (!empty($produits) && is_array($produits)): ?>
            <?php foreach ($produits as $produit): ?>
                <section>
                    <input type="checkbox" class="checkbox-produit" data-id="<?= $produit['id']; ?>" checked>
                    <img src="<?= ASSETS . '/images/' . $produit['image']; ?>" alt="<?= $produit['nom']; ?>">
                    <p><?= $produit['nom']; ?> : <?= $produit['prix']; ?>€</p>
                    <input type="number" class="quantite-produit" data-id="<?= $produit['id']; ?>" value="<?= $produit['quantite']; ?>" min="1">
                    <button class="btn-supprimer" data-id="<?= $produit['id']; ?>">Supprimer</button>
                </section><br>
            <?php endforeach; ?>
            <section>
                <p id="total-produits">0 articles dans le panier</p>
                <p id="total-prix">Total de la commande : 0€</p>
                <button class="btn-ajouter">Valider la commande</button>
            </section>
        <?php else: ?>
            <p>Votre panier est vide.</p>
        <?php endif; ?>
    </section>
</main>
