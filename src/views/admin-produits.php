<?php
require_once __DIR__ . '/../controllers/ProduitController.php';

// Crée une instance de ProduitController
$produitController = new ProduitController();
$products = $produitController->getAllProducts();
?>

<!-- Ajout dans le main avec la section -->
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
                <td class="editable" data-field="nom"><?php echo htmlspecialchars($product['nom']); ?></td>
                <td class="editable" data-field="description"><?php echo htmlspecialchars($product['description']); ?></td>
                <td>
                    <img src="<?php echo ASSETS; ?>/images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['nom']); ?>" width="50" class="current-image">
                    <div class="image-edit-container" style="display: none;">
                        <input type="file" name="image" style="display: none;" accept=".jpg,.jpeg,.png">
                        <button class="btn-choose-image">Choisir une image</button>
                        <span class="selected-file-name"></span>
                        <img src="" alt="Aperçu de l'image" class="image-preview" style="display: none; max-width: 100px; margin-top: 10px;">
                    </div>
                </td>
                <td class="editable" data-field="prix"><?php echo htmlspecialchars($product['prix']); ?> €</td>
                <td class="editable" data-field="quantite"><?php echo htmlspecialchars($product['quantite']); ?></td>
                <td><?php echo htmlspecialchars($product['nom_p']); ?></td>
                <td><?php echo htmlspecialchars($product['nom_sc']); ?></td>
                <td>
                    <button class="btn-edit">Modifier</button>
                    <button class="btn-save" style="display: none;">Valider</button>
                    <button class="btn-cancel" style="display: none;">Annuler</button>
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
<script src="<?php echo ASSETS; ?>/js/admin-produits.js"></script>
