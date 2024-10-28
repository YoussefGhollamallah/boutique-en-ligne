// Script pour la page panier :
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


// Pour index :
document.querySelectorAll('.form-ajouter-panier').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);

        fetch('', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            document.getElementById('confirmation-message').textContent = data;
            const popup = document.getElementById('confirmation-popup');
            popup.style.display = 'block';
            setTimeout(() => {
                popup.style.display = 'none';
            }, 3000);
        })
        .catch(error => console.error('Erreur:', error));
    });
});
