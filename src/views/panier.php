<?php

$panierController = new PanierController();
$panier = $panierController->afficherPanier();
?>

<section class="section">
    <h3>Votre Panier</h3>
    <?php if (!empty($panier)) { ?>
        <?php foreach ($panier as $idProduit => $produit) { ?>
            <div class="card_produit" id="produit_<?php echo $idProduit; ?>">
                <img class="card_produit_img" src="assets/images/<?php echo htmlspecialchars($produit['image']); ?>" alt="<?php echo htmlspecialchars($produit['nom']); ?>">
                <h4><input type="checkbox" class="produit-checkbox"><?php echo htmlspecialchars($produit['nom']); ?></h4>
                <p><?php echo htmlspecialchars($produit['description']); ?></p>
                <p>Prix unitaire : <?php echo htmlspecialchars($produit['prix']); ?> €</p>
                <p>Quantité :</p>
                <input type="number" value="<?php echo intval($produit['quantite']); ?>" min="1" class="quantite-input">
                <p>Total : <span class="produit-total"><?php echo htmlspecialchars($produit['prix'] * $produit['quantite']); ?> €</span></p>
                <button class="btn-supprimer" data-id="<?php echo $idProduit; ?>">Supprimer</button>
            </div>
        <?php } ?>
        <h4>Total du panier : <span id="total-panier"><?php echo array_sum(array_column($panier, 'prix')) ?> €</span></h4>
    <?php } else { ?>
        <p>Votre panier est vide.</p>
    <?php } ?>
</section>

<script>
    // JS pour gérer la suppression d'un produit du panier
    document.querySelectorAll('.btn-supprimer').forEach(button => {
        button.addEventListener('click', function() {
            const idProduit = this.dataset.id;

            // Requête fetch pour supprimer le produit via le contrôleur
            fetch('../src/controllers/PanierController.php?action=supprimer', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ idProduit: idProduit })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Supprimer le produit de l'affichage
                    document.getElementById('produit_' + idProduit).remove();
                    // Mettre à jour le total après suppression
                    updateTotal();
                } else {
                    console.error('Erreur lors de la suppression du produit');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
            });
        });
    });

    // Fonction pour mettre à jour le total
    function updateTotal() {
        let total = 0;

        document.querySelectorAll('.card_produit').forEach(produit => {
            const checkbox = produit.querySelector('input[type="checkbox"]');
            if (checkbox.checked) {
                const prix = parseFloat(produit.querySelector('p:nth-child(4)').textContent.split(' ')[2]);
                const quantite = parseInt(produit.querySelector('.quantite-input').value);
                total += prix * quantite;
            }
        });

        document.getElementById('total-panier').textContent = total.toFixed(2) + ' €';
    }
</script>
