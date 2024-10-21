<?php
require_once __DIR__ . '/../controllers/ProduitController.php';

// Crée une instance de ProduitController
$produitController = new ProduitController();
$products = $produitController->getAllProducts();
?>

<!-- Ajout du main avec la section -->
<main>
    <section class="section">
        <h1 class="section-title">Gestion des Produits</h1>
        
        <?php if (!empty($products)): ?>
        <!-- Tableau -->
        <table class="product-table">
            <!-- Ligne 1 : En-têtes -->
            <tr class="line-1">
                <td>ID</td>
                <td>Nom produit</td>
                <td class="description-header">Description</td>
                <td>Image</td>
                <td>Prix</td>
                <td>Quantité</td>
                <td>Sous-catégorie</td>
                <td>Catégorie</td>
                <td>Actions</td>
            </tr>
            <?php foreach ($products as $product): ?>
            <tr data-product-id="<?php echo $product['id']; ?>">
                <td><?php echo htmlspecialchars($product['id']); ?></td>
                <td class="editable" data-field="nom" data-type="varchar"><?php echo htmlspecialchars($product['nom']); ?></td>
                <td class="editable" data-field="description" data-type="text"><?php echo htmlspecialchars($product['description']); ?></td>
                <td><img src="../../assets/images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['nom']); ?>" width="50"></td>
                <td class="editable" data-field="prix" data-type="decimal"><?php echo htmlspecialchars($product['prix']); ?> €</td>
                <td class="editable" data-field="quantite" data-type="integer"><?php echo htmlspecialchars($product['quantite']); ?></td>
                <td><?php echo htmlspecialchars($product['nom_sc']); ?></td>
                <td><?php echo htmlspecialchars($product['nom_p']); ?></td>
                <td>
                    <button class="btn btn-edit">Modifier</button>
                    <button class="btn btn-save" style="display: none;">Valider</button>
                    <button class="btn btn-cancel" style="display: none;">Annuler</button>
                    <a href="delete-produit.php?id=<?php echo $product['id']; ?>" class="btn btn-delete" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?');">Supprimer</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php else: ?>
            <p>Aucun produit n'a été trouvé.</p>
        <?php endif; ?>
    </section>
</main>
<script>
var categories = <?php echo json_encode($categories); ?>;
var sousCategories = <?php echo json_encode($sousCategories); ?>;
</script>
<script src="../../assets/js/admin-produits.js"></script>



<style>
.product-table .editable input,
.product-table .editable textarea {
    width: 100%;
    box-sizing: border-box;
    padding: 5px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

.product-table .editable textarea {
    resize: vertical;
}
</style>

