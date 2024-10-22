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
                <td class="editable" data-field="nom" data-type="varchar"><?php echo htmlspecialchars($product['nom']); ?></td>
                <td class="editable" data-field="description" data-type="text"><?php echo htmlspecialchars($product['description']); ?></td>
                <td>
                    <input type="file" accept="image/png, image/jpeg" name="image" />
                    <!-- Ou si non en édition, afficher l'image -->
                    <img src="<?php echo ASSETS; ?>/images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['nom']); ?>" width="50">
                </td>
                <td class="editable" data-field="prix" data-type="decimal"><?php echo htmlspecialchars($product['prix']); ?> €</td>
                <td class="editable" data-field="quantite" data-type="integer"><?php echo htmlspecialchars($product['quantite']); ?></td>
                <td>
                    <?php if ($isEditing): ?>
                    <select name="categorie">
                        <?php foreach ($categories as $categorie): ?>
                            <option value="<?php echo $categorie['id']; ?>" <?php echo $categorie['id'] == $product['categorie_id'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($categorie['nom']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php else: ?>
                        <?php echo htmlspecialchars($product['nom_p']); ?>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if ($isEditing): ?>
                        <select name="sous_categorie">
                            <?php foreach ($sousCategories as $sousCategorie): ?>
                                <option value="<?php echo $sousCategorie['id']; ?>" <?php echo $sousCategorie['id'] == $product['sous_categorie_id'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($sousCategorie['nom']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    <?php else: ?>
                        <?php echo htmlspecialchars($product['nom_sc']); ?>
                    <?php endif; ?>
                </td>

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

