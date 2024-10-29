<?php

$panierController = new PanierController();
$panier = $panierController->afficherPanier();
$totalPanier = $panierController->calculerTotalPanier(); // Recalcul du total

$itemName = "Commande de produits : ";

foreach ($panier as $produit) {
    if (isset($produit['checked']) && $produit['checked']) {
        $itemName .= isset($produit['nom']) ? $produit['nom'] : "Produit inconnu" . ", ";
    }
}
$itemName = rtrim($itemName, ', ');

// Gestion des actions POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action']) && $_POST['action'] == 'supprimerProduit') {
        $idProduit = intval($_POST['id']);
        $result = $panierController->supprimerProduit($idProduit);
        echo $result ? "Le produit a bien été retiré du panier" : "Erreur lors de la suppression du produit";
        exit;
    }

    if (isset($_POST['action']) && $_POST['action'] == 'mettreAJourQuantite') {
        $idProduit = intval($_POST['id']);
        $quantite = intval($_POST['quantite']);
        $panierController->mettreAJourQuantite($idProduit, $quantite);
        exit;
    }

    if (isset($_POST['action']) && $_POST['action'] == 'mettreAJourChecked') {
        $idProduit = intval($_POST['id']);
        $checked = $_POST['checked'] === 'true';
        $panierController->mettreAJourCheckedProduit($idProduit, $checked);
        exit;
    }
}
?>

<section class="section">
    <h3>Votre Panier</h3>
    <?php if (!empty($panier)) { ?>
        <?php foreach ($panier as $idProduit => $produit) { ?>
            <div class="card_produit" id="produit_<?php echo htmlspecialchars($idProduit); ?>">
                <h4>
                    <input type="checkbox" class="produit-checkbox" data-id="<?php echo htmlspecialchars($idProduit); ?>" <?php echo $produit['checked'] ? 'checked' : ''; ?>>
                    <?php echo htmlspecialchars($produit['nom']); ?>
                </h4>
                <p>Prix unitaire : <span class="prix-produit"><?php echo htmlspecialchars($produit['prix']); ?></span> €</p>
                <p>Quantité :</p>
                <input type="number" value="<?php echo intval($produit['quantite']); ?>" min="1" class="quantite-input" data-id="<?php echo htmlspecialchars($idProduit); ?>">
                <button class="btn btn-supprimer" data-id="<?php echo intval($produit['id']); ?>">Supprimer</button>
            </div>
        <?php } ?>
        <h4>Total du panier : <span id="total-panier"><?php echo number_format($totalPanier, 2, ',', ' '); ?> €</span></h4>
    <?php } else { ?>
        <p>Votre panier est vide.</p>
    <?php } ?>
</section>

<script>
// Mettez à jour les fonctions JavaScript pour la gestion du panier si nécessaire
</script>


<div id="confirmation-popup" style="display: none; position: fixed; top: 20px; right: 20px; background-color: red; color: #e1664d; padding: 10px; border-radius: 20px;">
    <p id="confirmation-message"></p>
</div>

<script>
    // Fonction pour recalculer le total du panier
    function updateTotal() {
        let total = 0;

        // Parcourt chaque produit et calcule le total
        document.querySelectorAll('.cart-item').forEach(produit => {
            const checkbox = produit.querySelector('.produit-checkbox');
            const quantiteInput = produit.querySelector('.quantite-input');
            const prix = parseFloat(produit.querySelector('.prix-produit').textContent);
            const quantite = parseInt(quantiteInput.value);

            // Si le produit est coché, ajoute son coût au total
            if (checkbox.checked) {
                total += prix * quantite;
            }
        });

        // Met à jour le total affiché
        document.getElementById('total-panier').textContent = total.toFixed(2).replace('.', ',') + ' €';

        // Met à jour le champ `amount` dans le formulaire PayPal
        document.getElementById('paypal-amount').value = total.toFixed(2);
    }

    // Ajoute un écouteur d'événement sur les champs quantité et cases à cocher
    document.querySelectorAll('.quantite-input, .produit-checkbox').forEach(input => {
        input.addEventListener('change', updateTotal);
    });
</script>
