function changeQuantity(amount) {
    var input = document.getElementById('quantite');
    var currentValue = parseInt(input.value);
    var newValue = currentValue + amount;
    if (newValue >= parseInt(input.min) && newValue <= parseInt(input.max)) {
        input.value = newValue;
    }
}


document.querySelector('.form-ajouter-panier').addEventListener('submit', function(e) {
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

// Fonction pour changer la quantité
function changeQuantity(amount) {
    const quantiteInput = document.getElementById('quantite');
    let currentQuantity = parseInt(quantiteInput.value);
    currentQuantity += amount;
    
    // Vérification des limites
    if (currentQuantity < 1) {
        currentQuantity = 1;
    } else if (currentQuantity > parseInt(quantiteInput.max)) {
        currentQuantity = parseInt(quantiteInput.max);
    }
    
    quantiteInput.value = currentQuantity;
}