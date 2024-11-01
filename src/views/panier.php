<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php?r=connexion');
    exit;
}

$panierController = new PanierController();
$panier = $panierController->afficherPanier();
$totalPanier = $panierController->calculerTotalPanier();

// Initialisation de $itemName pour PayPal
$itemName = "Commande de produits : ";
foreach ($panier as $produit) {
    if ($produit['checked']) {
        $itemName .= $produit['nom'] . ", ";
    }
}
$itemName = rtrim($itemName, ', ');

// Gestion des actions AJAX
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $response = ['success' => false, 'message' => ''];

    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'supprimerProduit':
                $idProduit = intval($_POST['id']);
                $response['success'] = $panierController->supprimerProduit($idProduit);
                $response['message'] = $response['success'] ? "Le produit a bien été retiré du panier" : "Erreur lors de la suppression du produit";
                break;
            case 'mettreAJourQuantite':
                $idProduit = intval($_POST['id']);
                $quantite = intval($_POST['quantite']);
                $response['success'] = $panierController->mettreAJourQuantite($idProduit, $quantite);
                break;
            case 'mettreAJourChecked':
                $idProduit = intval($_POST['id']);
                $checked = $_POST['checked'] === 'true';
                $response['success'] = $panierController->mettreAJourCheckedProduit($idProduit, $checked);
                break;
        }
    }

    echo json_encode($response);
    exit;
}
?>

<section class="section_panier ">
    <h2>Votre Panier </h2>
    <div class="cart-container">
    <?php if (!empty($panier)) : ?>
        <div class="cart-items">
            <?php foreach ($panier as $produit) :
                $nomProduit = ucwords(str_replace('_', ' ', $produit['nom']));
            ?>
                <div class="card_produit cart-item" id="produit_<?php echo htmlspecialchars($produit['produit_id']); ?>">
                    <div class="flex align-center">
                        <input type="checkbox" class="produit-checkbox" data-id="<?php echo htmlspecialchars($produit['produit_id']); ?>" <?php echo $produit['checked'] ? 'checked' : ''; ?>>
                        <img class="card_produit_img" src="assets/images/<?php echo htmlspecialchars($produit['image']); ?>" alt="<?php echo htmlspecialchars($produit['nom']); ?>">
                        <h4>
                            <?php echo htmlspecialchars($nomProduit); ?>
                        </h4>
                    </div>
                    <div class="flex gap price">
                        <p>Prix : <span class="prix-produit"><?php echo htmlspecialchars($produit['prix']); ?></span> €</p>
                        <p class="hide_mobile">Sous-Total : <span class="produit-total"><?php echo htmlspecialchars((isset($produit['prix']) ? $produit['prix'] : 0) * (isset($produit['quantite']) ? $produit['quantite'] : 0)); ?> €</span></p>

                    </div>
                    <div class="flex small-gap align-center column">
                        <div class="flex vertical-center">
                            <p class="hide_mobile">Quantité :</p>
                            <input type="number" class="quantite-input" value="<?php echo intval($produit['quantite']); ?>" min="1" max="<?php echo intval($produit['quantite_disponible']); ?>" class="quantite-input" data-id="<?php echo htmlspecialchars($produit['produit_id']); ?>">
                        </div>
                        <button class="btn btn-supprimer" data-id="<?php echo htmlspecialchars($produit['produit_id']); ?>">Supprimer</button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="cart-summary">
            <h4>Total du panier : <span id="total-panier"><?php echo number_format($totalPanier, 2, ',', ' '); ?> €</span></h4>

            <!-- Formulaire de paiement PayPal -->
            <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
                <input type="hidden" name="cmd" value="_xclick">
                <input type="hidden" name="business" value="sb-ogdke33654309@business.example.com">
                <input type="hidden" name="item_name" value="<?php echo htmlspecialchars($itemName); ?>">
                <input type="hidden" name="amount" id="paypal-amount" value="<?php echo number_format($totalPanier, 2, '.', ''); ?>">
                <input type="hidden" name="currency_code" value="EUR">
                <input type="hidden" name="return" value="http://localhost/boutique-en-ligne/index.php?r=confirmation&status=success">
                <input type="hidden" name="cancel_return" value="http://localhost/boutique-en-ligne/panier">
                <button type="submit" class="btn btn-ajouter">Payer avec PayPal</button>
            </form>
        </div>
    <?php else : ?>
        <p>Votre panier est vide.</p>
    <?php endif; ?>
    </div>
</section>

<div id="confirmation-popup" style="display: none; position: fixed; top: 20px; right: 20px; background-color: #4CAF50; color: white; padding: 10px; border-radius: 20px; z-index: 100;">
    <p id="confirmation-message"></p>
</div>

<script src="<?php echo ASSETS; ?>/js/panier.js"></script>