// Fonction pour mettre à jour le total d'un produit et du panier
function updateTotal(productElement) {
    const checkbox = productElement.querySelector('.produit-checkbox');
    const prix = parseFloat(productElement.querySelector('.prix-produit').textContent);
    const quantite = parseInt(productElement.querySelector('.quantite-input').value);
    const totalElement = productElement.querySelector('.produit-total');

    if (!isNaN(prix) && !isNaN(quantite) && quantite > 0) {
        const total = prix * quantite;
        totalElement.textContent = total.toFixed(2) + ' €';
        
        updatePanierTotal();
    }
}

// Fonction pour mettre à jour le total du panier
function updatePanierTotal() {
    let total = 0;
    document.querySelectorAll('.card_produit').forEach(produit => {
        const checkbox = produit.querySelector('.produit-checkbox');
        if (checkbox.checked) {
            const prix = parseFloat(produit.querySelector('.prix-produit').textContent);
            const quantite = parseInt(produit.querySelector('.quantite-input').value);
            if (!isNaN(prix) && !isNaN(quantite) && quantite > 0) {
                total += prix * quantite;
            }
        }
    });

    const totalPanierElement = document.getElementById('total-panier');
    const paypalAmountElement = document.getElementById('paypal-amount');
    
    if (totalPanierElement) {
        totalPanierElement.textContent = total.toFixed(2).replace('.', ',') + ' €';
    }
    if (paypalAmountElement) {
        paypalAmountElement.value = total.toFixed(2);
    }
}

// Fonction pour envoyer une requête AJAX
function sendAjaxRequest(action, id, value) {
    return fetch('index.php?r=panier&action=' + action, {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `id=${id}&${action === 'mettreAJourQuantite' ? 'quantite' : 'checked'}=${value}`
    })
    .then(response => response.json())
    .then(data => {
        if (!data.success) {
            console.error(`Erreur lors de la mise à jour : ${action}`);
        }
        return data.success;
    })
    .catch(error => {
        console.error('Erreur:', error);
        return false;
    });
}

// Gestionnaire d'événements pour les cases à cocher et les champs de quantité
document.querySelectorAll('.produit-checkbox, .quantite-input').forEach(element => {
    element.addEventListener('change', function() {
        const productElement = this.closest('.card_produit');
        const productId = this.dataset.id;
        
        if (this.classList.contains('produit-checkbox')) {
            sendAjaxRequest('mettreAJourChecked', productId, this.checked);
        } else {
            sendAjaxRequest('mettreAJourQuantite', productId, this.value);
        }
        
        updateTotal(productElement);
    });
});

// Gestionnaire d'événements pour les boutons de suppression
document.querySelectorAll('.btn-supprimer').forEach(button => {
    button.addEventListener('click', function() {
        const productId = this.dataset.id;
        sendAjaxRequest('supprimerProduit', productId)
            .then(success => {
                if (success) {
                    const productElement = document.getElementById('produit_' + productId);
                    if (productElement) {
                        productElement.remove();
                        updatePanierTotal();
                    }
                    const popup = document.getElementById('confirmation-popup');
                    popup.querySelector('#confirmation-message').textContent = "Le produit a été retiré du panier.";
                    popup.style.display = 'block';
                    setTimeout(() => popup.style.display = 'none', 3000);
                }
            });
    });
});

// Initialisation
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.card_produit').forEach(updateTotal);
    updatePanierTotal();
});