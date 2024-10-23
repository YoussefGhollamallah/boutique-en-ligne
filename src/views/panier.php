<?php
session_start();

$panierController = new PanierController();
$panier = $panierController->afficherPanier();

$totalPanier = 0; // Initialiser le total du panier
if (!empty($panier)) {
    // Calculer le total du panier
    foreach ($panier as $produit) {
        if (isset($produit['checked']) && $produit['checked']) {
            $totalPanier += $produit['prix'] * $produit['quantite'];
        }
    }
}
?>

<section class="section">
    <h3>Votre Panier</h3>
    <?php if (!empty($panier)) { ?>
        <?php foreach ($panier as $idProduit => $produit) {
            $checked = isset($produit['checked']) ? $produit['checked'] : false; ?>
            <div class="card_produit" id="produit_<?php echo htmlspecialchars($idProduit); ?>">
                <img class="card_produit_img" src="assets/images/<?php echo htmlspecialchars($produit['image']); ?>" alt="<?php echo htmlspecialchars($produit['nom']); ?>">
                <h4>
                    <input type="checkbox" class="produit-checkbox" data-id="<?php echo htmlspecialchars($idProduit); ?>" <?php echo $checked ? 'checked' : ''; ?>>
                    <?php echo htmlspecialchars($produit['nom']); ?>
                </h4>
                <p><?php echo htmlspecialchars($produit['description']); ?></p>
                <p>Prix unitaire : <span class="prix-produit"><?php echo htmlspecialchars($produit['prix']); ?></span> €</p>
                <p>Quantité :</p>
                <input type="number" value="<?php echo intval($produit['quantite']); ?>" min="1" class="quantite-input" data-id="<?php echo htmlspecialchars($idProduit); ?>">
                <p>Total : <span class="produit-total"><?php echo htmlspecialchars($produit['prix'] * $produit['quantite']); ?> €</span></p>
                <button class="btn-supprimer" data-id="<?php echo htmlspecialchars($idProduit); ?>">Supprimer</button>
            </div>
        <?php } ?>
        <h4>Total du panier : <span id="total-panier"><?php echo number_format($totalPanier, 2, ',', ' '); ?> €</span></h4>
        <button class="btn-valider">Valider la commande</button>
    <?php } else { ?>
        <p>Votre panier est vide.</p>
    <?php } ?>
</section>

<script>
    // Fonction pour mettre à jour le total d'un produit
    function updateTotalProduit(idProduit) {
        const produitElement = document.getElementById('produit_' + idProduit);
        const prix = parseFloat(produitElement.querySelector('.prix-produit').textContent);
        const quantite = parseInt(produitElement.querySelector('.quantite-input').value);

        if (!isNaN(prix) && !isNaN(quantite) && quantite > 0) {
            const totalProduit = prix * quantite;
            produitElement.querySelector('.produit-total').textContent = totalProduit.toFixed(2) + ' €';
        }
        updateTotalPanier(); // Mettez à jour le total du panier après chaque modification
    }

    // Fonction pour mettre à jour le total du panier
    function updateTotalPanier() {
        let total = 0;

        document.querySelectorAll('.card_produit').forEach(produit => {
            const checkbox = produit.querySelector('.produit-checkbox');
            const prix = parseFloat(produit.querySelector('.prix-produit').textContent);
            const quantite = parseInt(produit.querySelector('.quantite-input').value);

            if (checkbox.checked && !isNaN(prix) && !isNaN(quantite) && quantite > 0) {
                total += prix * quantite;
            }
        });

        document.getElementById('total-panier').textContent = total.toFixed(2).replace('.', ',') + ' €'; // Remplacer le point par une virgule
    }

    // Fonction pour sauvegarder l'état des cases à cocher
    function saveCheckboxState() {
        const checkboxStates = {};

        document.querySelectorAll('.produit-checkbox').forEach(checkbox => {
            checkboxStates[checkbox.dataset.id] = checkbox.checked;
        });

        localStorage.setItem('checkboxStates', JSON.stringify(checkboxStates));
    }

    // Fonction pour charger l'état des cases à cocher
    function loadCheckboxState() {
        const checkboxStates = JSON.parse(localStorage.getItem('checkboxStates')) || {};

        document.querySelectorAll('.produit-checkbox').forEach(checkbox => {
            const produitId = checkbox.dataset.id;
            checkbox.checked = checkboxStates[produitId] || false; // Met à jour l'état de la case à cocher
        });
    }

    // Ajoutez des écouteurs d'événements pour chaque case à cocher et entrée de quantité
    document.querySelectorAll('.produit-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateTotalPanier();
            saveCheckboxState(); // Sauvegardez l'état lorsque la case est cochée ou décochée
        });
    });

    document.querySelectorAll('.quantite-input').forEach(input => {
        input.addEventListener('input', function() {
            updateTotalProduit(this.dataset.id);
        });
    });

    // Chargez l'état des cases à cocher au chargement de la page
    document.addEventListener('DOMContentLoaded', function() {
        loadCheckboxState();
        updateTotalPanier(); // Mettez également à jour le total du panier
    });
</script>
