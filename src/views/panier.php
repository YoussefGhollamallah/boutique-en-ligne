<?php
session_start();

$panierController = new PanierController();
$panier = $panierController->afficherPanier();

$totalPanier = 0;
if (!empty($panier)) {
    foreach ($panier as $produit) {
        if (isset($produit['checked']) && $produit['checked']) {
            $totalPanier += $produit['prix'] * $produit['quantite'];
        }
    }
}

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
}
?>

<section class="section_panier ">
    <div class="cart-container">
        <?php if (!empty($panier)) { ?>
            <div class="cart-items">
                <h2>Panier :</h2>

                <?php foreach ($panier as $idProduit => $produit) {
                    $checked = isset($produit['checked']) ? $produit['checked'] : false; ?>

                    <div class="cart-item" id="produit_<?php echo htmlspecialchars($idProduit); ?>">
                        <input type="checkbox" class="produit-checkbox" data-id="<?php echo htmlspecialchars($idProduit); ?>" <?php echo $checked ? 'checked' : ''; ?>>
                        <a href="<?php echo BASE_URL; ?>detail/<?php echo intval($produit['id']); ?>">

                            <img class="cart-item-img" src="assets/images/<?php echo htmlspecialchars($produit['image']); ?>" alt="<?php echo htmlspecialchars($produit['nom']); ?>">
                        </a>
                        <span id="nom_panier"><?php echo htmlspecialchars($produit['nom']); ?> :</span>
                        <span><?php echo htmlspecialchars($produit['prix']); ?>€</span>

                        <input type="number" value="<?php echo intval($produit['quantite']); ?>" min="1" max="<?php echo intval($produit['quantite_max']); ?>" class="quantity-input" data-id="<?php echo htmlspecialchars($idProduit); ?>">

                        <button class="btn btn-supprimer" data-id="<?php echo intval($produit['id']); ?>">Supprimer</button>
                    </div>
                <?php } ?>
            </div>

            <div class="cart-summary">
                <p><?php echo count($panier); ?> articles dans le panier</p>
                <p>Total de la commande : <span id="total-panier"><?php echo number_format($totalPanier, 2, ',', ' '); ?> €</span></p>
                <button class="btn btn-ajouter">Valider la commande</button>
            </div>

        <?php } else { ?>
            <p>Votre panier est vide.</p>
        <?php } ?>
    </div>

</section>

<div id="confirmation-popup" style="display: none; position: fixed; top: 20px; right: 20px; background-color: red; color: #e1664d; padding: 10px; border-radius: 20px;">
    <p id="confirmation-message"></p>
</div>

<script>
    function updateTotalProduit(idProduit) {
        const produitElement = document.getElementById('produit_' + idProduit);
        const prix = parseFloat(produitElement.querySelector('.prix-produit').textContent);
        const quantite = parseInt(produitElement.querySelector('.quantite-input').value);

        if (!isNaN(prix) && !isNaN(quantite) && quantite > 0) {
            const totalProduit = prix * quantite;
            produitElement.querySelector('.produit-total').textContent = totalProduit.toFixed(2) + ' €';
        }
        updateTotalPanier();
        saveQuantite(idProduit, quantite);
    }

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

        document.getElementById('total-panier').textContent = total.toFixed(2).replace('.', ',') + ' €';
    }

    function saveQuantite(idProduit, quantite) {
        fetch('', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `action=mettreAJourQuantite&id=${idProduit}&quantite=${quantite}`
        });
    }

    function saveCheckboxState(idProduit, checked) {
        fetch('', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `action=mettreAJourChecked&id=${idProduit}&checked=${checked}`
        });
    }

    document.querySelectorAll('.produit-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateTotalPanier();
            saveCheckboxState(this.dataset.id, this.checked);
        });
    });

    document.querySelectorAll('.quantite-input').forEach(input => {
        input.addEventListener('input', function() {
            updateTotalProduit(this.dataset.id);
        });
    });

    document.querySelectorAll('.btn-supprimer').forEach(button => {
        button.addEventListener('click', function() {
            const idProduit = this.dataset.id;
            fetch('', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `action=supprimerProduit&id=${idProduit}`
                })
                .then(response => response.text())
                .then(data => {
                    document.getElementById('confirmation-message').textContent = data;
                    const popup = document.getElementById('confirmation-popup');
                    popup.style.display = 'block';
                    setTimeout(() => {
                        popup.style.display = 'none';
                    }, 3000);

                    const produitElement = document.getElementById('produit_' + idProduit);
                    if (produitElement) {
                        produitElement.remove();
                    }
                    updateTotalPanier();
                })
                .catch(error => console.error('Erreur:', error));
        });
    });

    document.addEventListener('DOMContentLoaded', updateTotalPanier);
</script>