// Path: assets/js/categorie.js

let debounceTimeout;

const categorie = (categorieId) => {
    const produitContainer = document.getElementById('produit-container');

    // Debounce logic: clear the previous timeout
    if (debounceTimeout) clearTimeout(debounceTimeout);

    debounceTimeout = setTimeout(async () => {
        try {
            const req = await fetch(`src/controllers/getProductsByCategory.php?categorieId=${categorieId}`);
            if (!req.ok) {
                throw new Error(`Erreur HTTP ! Statut : ${req.status}`);
            }

            const contentType = req.headers.get("content-type");
            const responseText = await req.text();

            console.log("Texte de la réponse :", responseText);

            if (contentType && contentType.includes("application/json")) {
                const produits = JSON.parse(responseText);
                produitContainer.innerHTML = ''; // Clear previous results

                if (produits.length > 0) {
                    produits.forEach((produit) => {
                        const produitElement = document.createElement("div");
                        produitElement.classList.add("produit-item"); // Classe pour style

                        produitElement.innerHTML = `
                            <h3>${produit.nom}</h3>
                            <p>${produit.description}</p>
                            <p>Prix : ${produit.prix} €</p>
                        `;

                        produitContainer.appendChild(produitElement);
                    });
                    produitContainer.style.display = 'block'; // Affiche les produits
                } else {
                    produitContainer.innerHTML = "<div>Aucun produit trouvé pour cette catégorie</div>";
                    produitContainer.style.display = 'block';
                }
            } else {
                throw new Error("Réponse reçue non au format JSON");
            }
        } catch (error) {
            console.error('Erreur lors de la récupération et de l\'analyse des données', error);
        }
    }, 300); // Délai de debounce en millisecondes
};

// Associer la fonction au clic des boutons de catégorie
document.querySelectorAll('.categorie-button').forEach(button => {
    button.addEventListener('click', () => {
        const categorieId = button.getAttribute('data-categorie-id');
        fetchProductsByCategory(categorieId);
    });
});
