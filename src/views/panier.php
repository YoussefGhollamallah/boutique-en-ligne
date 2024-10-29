<?php
session_start();

$panierController = new PanierController();
$panier = $panierController->afficherPanier();
$totalPanier = $panierController->calculerTotalPanier(); // Recalcul du total

// Initialisation de $itemName pour passer des informations sur la commande à PayPal
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
        if ($result) {
            echo "Le produit a bien été retiré du panier";
        } else {
            echo "Erreur lors de la suppression du produit";
        }
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

    // Construction de $itemName à partir du panier
    foreach ($panier as $produit) {
        if (isset($produit['checked']) && $produit['checked']) {
            $itemName .= isset($produit['nom']) ? $produit['nom'] : "Produit inconnu" . ", ";
        }
    }
    $itemName = rtrim($itemName, ', '); // Enlève la dernière virgule
}
?>

<section class="section">
    <h3>Votre Panier</h3>
    <?php if (!empty($panier)) { ?>
        <?php foreach ($panier as $idProduit => $produit) {
            $checked = isset($produit['checked']) ? $produit['checked'] : false; ?>
            <div class="card_produit" id="produit_<?php echo htmlspecialchars($idProduit); ?>">
                <img class="card_produit_img" src="assets/images/<?php echo htmlspecialchars(isset($produit['image']) ? $produit['image'] : 'default.jpg'); ?>" alt="<?php echo htmlspecialchars(isset($produit['nom']) ? $produit['nom'] : 'Produit inconnu'); ?>">
                <h4>
                    <input type="checkbox" class="produit-checkbox" data-id="<?php echo htmlspecialchars($idProduit); ?>" <?php echo $checked ? 'checked' : ''; ?>>
                    <?php echo htmlspecialchars(isset($produit['nom']) ? $produit['nom'] : 'Produit inconnu'); ?>
                </h4>
                <p><?php echo htmlspecialchars(isset($produit['description']) ? $produit['description'] : 'Aucune description disponible.'); ?></p>
                <p>Prix unitaire : <span class="prix-produit"><?php echo htmlspecialchars(isset($produit['prix']) ? $produit['prix'] : 0); ?></span> €</p>
                <p>Quantité :</p>
                <input type="number" value="<?php echo intval(isset($produit['quantite']) ? $produit['quantite'] : 1); ?>" min="1" max="<?php echo intval(isset($produit['quantite_max']) ? $produit['quantite_max'] : 1); ?>" class="quantite-input" data-id="<?php echo htmlspecialchars($idProduit); ?>">
                <p>Total : <span class="produit-total"><?php echo htmlspecialchars((isset($produit['prix']) ? $produit['prix'] : 0) * (isset($produit['quantite']) ? $produit['quantite'] : 0)); ?> €</span></p>
                <button class="btn btn-supprimer" data-id="<?php echo intval(isset($produit['id']) ? $produit['id'] : 0); ?>">Supprimer</button>
            </div>
        <?php } ?>

        <h4>Total du panier : <span id="total-panier"><?php echo number_format($totalPanier, 2, ',', ' '); ?> €</span></h4>
        
        <!-- Formulaire de paiement PayPal -->
        <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
            <input type="hidden" name="cmd" value="_xclick">
            <input type="hidden" name="business" value="sb-ogdke33654309@business.example.com"> <!-- Remplacez par votre email sandbox -->
            <input type="hidden" name="item_name" value="<?php echo htmlspecialchars($itemName); ?>">            
            <input type="hidden" name="amount" id="paypal-amount" value="<?php echo number_format($totalPanier, 2, '.', ''); ?>">
            <input type="hidden" name="currency_code" value="EUR">
            <input type="hidden" name="return" value="http://localhost/boutique-en-ligne/confirmation">
            <input type="hidden" name="cancel_return" value="http://localhost/boutique-en-ligne/panier">
            <button type="submit" class="btn btn-ajouter">Payer avec PayPal</button>
        </form>
        
    <?php } else { ?>
        <p>Votre panier est vide.</p>
    <?php } ?>
</section>

<div id="confirmation-popup" style="display: none; position: fixed; top: 20px; right: 20px; background-color: red; color: #e1664d; padding: 10px; border-radius: 20px;">
    <p id="confirmation-message"></p>
</div>

<script>

// Fonction pour recalculer le total du panier
function updateTotal() {
    let total = 0;

    // Parcourt chaque produit et calcule le total
    document.querySelectorAll('.card_produit').forEach(produit => {
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
