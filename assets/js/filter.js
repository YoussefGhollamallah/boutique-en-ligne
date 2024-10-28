function filterProducts(categorieId) {
    const productList = document.getElementById('product-list');
    const sectionPhare = document.querySelector('.section_phare');

    const selectedCategory = document.querySelector(`.card_categorie[onclick="filterProducts(${categorieId})"]`);

    if (selectedCategory.classList.contains('active-category')) {
        // Si elle est active, on la désactive et on réaffiche la section des produits phares
        selectedCategory.classList.remove('active-category');
        sectionPhare.style.display = 'block'; 
        productList.innerHTML = ''; 
        return; 
    }

    // Sinon, désactiver toutes les catégories et activer celle sélectionnée
    document.querySelectorAll('.card_categorie').forEach(categorie => {
        categorie.classList.remove('active-category');
    });
    selectedCategory.classList.add('active-category');

    // Masquer la section des produits phares et réinitialiser la liste
    sectionPhare.style.display = 'none';
    productList.innerHTML = '';

    // Utiliser la variable `pageURL` pour faire la requête
    fetch(`${pageURL}?categorieId=${categorieId}`)
        .then(response => response.json())
        .then(data => {
            if (data.length > 0) {
                data.forEach(produit => {
                    const productCard = document.createElement('div');
                    productCard.classList.add('card_produit');
                    productCard.innerHTML = `
                        <a href="${BASE_URL}detail/${produit.id}">
                            <img class="card_produit_img" src="${ASSETS}/images/${produit.image}" alt="${produit.nom}">
                        </a>
                        <h4>${produit.nom}</h4>
                        <p>${produit.prix} €</p>
                        <form class="form-ajouter-panier" method="POST" action="">
                            <input type="hidden" name="id" value="${produit.id}">
                            <input type="hidden" name="action" value="ajouterProduitAuPanier">
                            <button class="btn btn-ajouter" type="submit">Ajouter au panier</button>
                        </form>
                    `;
                    productList.appendChild(productCard);
                });
            } else {
                productList.innerHTML = '<p>Aucun produit trouvé dans cette catégorie.</p>';
            }
        })
        .catch(error => console.error('Erreur lors de la récupération des produits:', error));
}
