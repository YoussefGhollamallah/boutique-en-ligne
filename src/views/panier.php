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
    $response = ['success' => false];
    
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'supprimerProduit':
                $idProduit = intval($_POST['id']);
                $response['success'] = $panierController->supprimerProduit($idProduit);
                break;
            case 'mettreAJourQuantite':
                $idProduit = intval($_POST['id']);
                $quantite = intval($_POST['quantite']);
                $panierController->mettreAJourQuantite($idProduit, $quantite);
                $response['success'] = true;
                break;
            case 'mettreAJourChecked':
                $idProduit = intval($_POST['id']);
                $checked = $_POST['checked'] === 'true';
                $panierController->mettreAJourCheckedProduit($idProduit, $checked);
                $response['success'] = true;
                break;
        }
    }
    
    echo json_encode($response);
    exit;
}
?>

<section class="section">
    <h3>Votre Panier</h3>
    <?php if (!empty($panier)) : ?>
        <?php foreach ($panier as $produit) : ?>
            <div class="card_produit" id="produit_<?php echo htmlspecialchars($produit['produit_id']); ?>">
                <img class="card_produit_img" src="assets/images/<?php echo htmlspecialchars($produit['image']); ?>" alt="<?php echo htmlspecialchars($produit['nom']); ?>">
                <h4>
                    <input type="checkbox" class="produit-checkbox" data-id="<?php echo htmlspecialchars($produit['produit_id']); ?>" <?php echo $produit['checked'] ? 'checked' : ''; ?>>
                    <?php echo htmlspecialchars($produit['nom']); ?>
                </h4>
                <p><?php echo htmlspecialchars($produit['description']); ?></p>
                <p>Prix unitaire : <span class="prix-produit"><?php echo htmlspecialchars($produit['prix']); ?></span> €</p>
                <p>Quantité :</p>
                <input type="number" value="<?php echo intval($produit['quantite']); ?>" min="1" class="quantite-input" data-id="<?php echo htmlspecialchars($produit['produit_id']); ?>">
                <p>Total : <span class="produit-total"><?php echo htmlspecialchars($produit['prix'] * $produit['quantite']); ?> €</span></p>
                <button class="btn btn-supprimer" data-id="<?php echo htmlspecialchars($produit['produit_id']); ?>">Supprimer</button>
            </div>
        <?php endforeach; ?>

        <h4>Total du panier : <span id="total-panier"><?php echo number_format($totalPanier, 2, ',', ' '); ?> €</span></h4>
        
        <!-- Formulaire de paiement PayPal -->
        <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
            <input type="hidden" name="cmd" value="_xclick">
            <input type="hidden" name="business" value="sb-ogdke33654309@business.example.com">
            <input type="hidden" name="item_name" value="<?php echo htmlspecialchars($itemName); ?>">            
            <input type="hidden" name="amount" id="paypal-amount" value="<?php echo number_format($totalPanier, 2, '.', ''); ?>">
            <input type="hidden" name="currency_code" value="EUR">
            <input type="hidden" name="return" value="http://localhost/boutique-en-ligne/index.php?r=confirmation&status=success">
            <input type="hidden" name="cancel_return" value="http://localhost/boutique-en-ligne/index.php?r=panier">
            <button type="submit" class="btn btn-ajouter">Payer avec PayPal</button>
        </form>
    <?php else : ?>
        <p>Votre panier est vide.</p>
    <?php endif; ?>
</section>

<div id="confirmation-popup" style="display: none; position: fixed; top: 20px; right: 20px; background-color: #4CAF50; color: white; padding: 10px; border-radius: 5px;">
    <p id="confirmation-message"></p>
</div>

<script src="assets/js/panier.js"></script>