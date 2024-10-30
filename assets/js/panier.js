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
            updateCartTotal(); // Met à jour le total global du panier
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
}

// Fonction pour envoyer une requête AJAX
function sendAjaxRequest(action, id, value) {
    return fetch(`index.php?r=panier&action=${action}`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `id=${id}&${action === 'mettreAJourQuantite' ? 'quantite' : 'checked'}=${value}`
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json(); // On attend une réponse JSON
    })
    .then(data => {
        if (!data.success) {
            console.error(`Erreur lors de la mise à jour : ${action}`);
        }
        return data.success;
    })
    .catch(error => {
        console.error('Erreur:', error);
    });
}

// Gestionnaire d'événements pour les modifications de quantité et de sélection
document.querySelectorAll('.produit-checkbox, .quantite-input').forEach(element => {
    element.addEventListener('change', function() {
        const productElement = this.closest('.card_produit');
        const productId = this.dataset.id;

        if (this.classList.contains('produit-checkbox')) {
            sendAjaxRequest('mettreAJourChecked', productId, this.checked);
        } else {
            sendAjaxRequest('mettreAJourQuantite', productId, this.value);
        }

        updateTotal(productElement); // Met à jour le total du produit
    });
});


// Gestionnaire d'événements pour les modifications de quantité et de sélection
document.querySelectorAll('.quantite-input').forEach(input => {
    input.addEventListener('change', function() {
        const maxQuantite = parseInt(this.max);
        const quantite = parseInt(this.value);
        
        if (quantite > maxQuantite) {
            this.value = maxQuantite; // Limite la quantité à max si elle dépasse
        }
        
        const productId = this.dataset.id;
        sendAjaxRequest('mettreAJourQuantite', productId, this.value);
        updateTotal(this.closest('.card_produit'));
    });
});


// Initialisation
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.card_produit').forEach(updateTotal);
    updateCartTotal();
});
