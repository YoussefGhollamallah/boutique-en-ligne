// Fonction pour mettre à jour le total d'un produit
function updateTotal(productElement) {
    const checkbox = productElement.querySelector('.produit-checkbox');
    const prixElement = productElement.querySelector('.prix-produit');
    const quantiteInput = productElement.querySelector('.quantite-input');
    const totalElement = productElement.querySelector('.produit-total');

    if (prixElement && quantiteInput && totalElement) {
        const prix = parseFloat(prixElement.textContent);
        const quantite = parseInt(quantiteInput.value);

        if (!isNaN(prix) && !isNaN(quantite) && quantite > 0) {
            const total = prix * quantite;
            totalElement.textContent = total.toFixed(2) + ' €';
            updateCartTotal();
        }
    }
}

// Fonction pour mettre à jour le total global du panier
function updateCartTotal() {
    let total = 0;
    const products = document.querySelectorAll('.card_produit');

    products.forEach(product => {
        const checkbox = product.querySelector('.produit-checkbox');
        const prix = parseFloat(product.querySelector('.prix-produit').textContent);
        const quantite = parseInt(product.querySelector('.quantite-input').value);

        if (checkbox.checked && !isNaN(prix) && !isNaN(quantite) && quantite > 0) {
            total += prix * quantite;
        }
    });

    const totalPanierElement = document.getElementById('total-panier');
    if (totalPanierElement) {
        totalPanierElement.textContent = total.toFixed(2).replace('.', ',') + ' €';
    }

    // Mise à jour du montant PayPal
    const paypalAmountElement = document.getElementById('paypal-amount');
    if (paypalAmountElement) {
        paypalAmountElement.value = total.toFixed(2);
    }
}

// Fonction pour envoyer une requête AJAX
function sendAjaxRequest(action, id, value) {
    return fetch('index.php?r=panier', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `action=${action}&id=${id}&${action === 'mettreAJourQuantite' ? 'quantite' : 'checked'}=${value}`
    })
    .then(response => response.json())
    .catch(error => {
        console.error('Erreur:', error);
    });
}

// Fonction pour supprimer un produit
function supprimerProduit(productId) {
    sendAjaxRequest('supprimerProduit', productId)
        .then(data => {
            if (data.success) {
                const productElement = document.getElementById('produit_' + productId);
                if (productElement) {
                    productElement.remove();
                    updateCartTotal();
                }
                showConfirmation("Le produit a bien été retiré du panier.");
            } else {
                showConfirmation("Erreur lors de la suppression du produit.", true);
            }
        });
}

// Fonction pour afficher une confirmation
function showConfirmation(message, isError = false) {
    const popup = document.getElementById('confirmation-popup');
    const messageElement = document.getElementById('confirmation-message');
    messageElement.textContent = message;
    popup.style.backgroundColor = isError ? '#e1664d' : '#4CAF50';
    popup.style.display = 'block';
    setTimeout(() => popup.style.display = 'none', 3000);
}

// Écouteurs d'événements pour les changements de quantité et les cases à cocher
document.querySelectorAll('.quantite-input, .produit-checkbox').forEach(input => {
    input.addEventListener('change', function() {
        const productElement = this.closest('.card_produit');
        const productId = this.getAttribute('data-id');
        const action = this.type === 'checkbox' ? 'mettreAJourChecked' : 'mettreAJourQuantite';
        const value = this.type === 'checkbox' ? this.checked : this.value;
        
        updateTotal(productElement);
        sendAjaxRequest(action, productId, value);
    });
});

// Écouteurs d'événements pour les boutons de suppression
document.querySelectorAll('.btn-supprimer').forEach(button => {
    button.addEventListener('click', function() {
        const productId = this.getAttribute('data-id');
        supprimerProduit(productId);
    });
});

// Initialisation
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.card_produit').forEach(updateTotal);
    updateCartTotal();
});