<main id="panier">
    <section class="section">
        <h2>Panier :</h2>
        <?php if (!empty($produits)): ?>
            <?php foreach ($produits as $id => $produit): ?>
                <section>
                    <input type="checkbox" class="checkbox-produit" data-id="<?= $id; ?>" checked>
                    <img src="<?= ASSETS . '/images/' . $produit['image']; ?>" alt="<?= $produit['nom']; ?>">
                    <p><?= $produit['nom']; ?> : <?= $produit['prix']; ?>€</p>
                    <input type="number" class="quantite-produit" data-id="<?= $id; ?>" value="<?= $produit['quantite']; ?>" min="1">
                    <button class="btn-supprimer" data-id="<?= $id; ?>">Supprimer</button>
                </section><br>
            <?php endforeach; ?>
            <section>
                <p id="total-produits">Total des articles cochés : 0</p>
                <p id="total-prix">Total de la commande : 0€</p>
                <button class="btn-ajouter">Valider la commande</button>
            </section>
        <?php else: ?>
            <p>Votre panier est vide.</p>
        <?php endif; ?>
    </section>
</main>

<script>
document.querySelectorAll('.quantite-produit').forEach(input => {
    input.addEventListener('change', function() {
        const id = this.getAttribute('data-id');
        const quantite = this.value;
        updateQuantite(id, quantite);
    });
});

document.querySelectorAll('.btn-supprimer').forEach(button => {
    button.addEventListener('click', function() {
        const id = this.getAttribute('data-id');
        supprimerProduit(id);
    });
});

document.querySelectorAll('.checkbox-produit').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        calculerTotal();
    });
});

document.querySelector('.btn-ajouter').addEventListener('click', function() {
    validerCommande();
});

function updateQuantite(id, quantite) {
    fetch('index.php?action=updateQuantite', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id: id, quantite: quantite })
    })
    .then(response => response.json())
    .then(() => calculerTotal())
    .catch(error => console.error('Erreur:', error));
}

function supprimerProduit(id) {
    fetch('index.php?action=supprimerProduit', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id: id })
    })
    .then(response => response.json())
    .then(() => location.reload())
    .catch(error => console.error('Erreur:', error));
}

function validerCommande() {
    fetch('index.php?action=validerCommande', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' }
    })
    .then(response => response.json())
    .then(() => alert('Commande validée !'))
    .catch(error => console.error('Erreur:', error));
}

function calculerTotal() {
    let totalPrix = 0;
    let totalProduits = 0;

    document.querySelectorAll('.checkbox-produit:checked').forEach(checkbox => {
        const section = checkbox.closest('section');
        const prix = parseFloat(section.querySelector('p').textContent.match(/(\d+\.\d+)/)[0]);
        const quantite = parseInt(section.querySelector('.quantite-produit').value);

        totalPrix += prix * quantite;
        totalProduits += quantite;
    });

    document.getElementById('total-prix').textContent = `Total de la commande : ${totalPrix.toFixed(2)}€`;
    document.getElementById('total-produits').textContent = `Total des articles cochés : ${totalProduits}`;
}

calculerTotal();  // Calcul initial du total
</script>
