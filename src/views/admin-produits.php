<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user'])) {
    header('Location: connexion');
    exit;
}

if (isset($_SESSION["user"]["role_id"]) && $_SESSION["user"]["role_id"] != 1) {
    header('Location: index');
    exit;
}

// Crée une instance de ProduitController
$produitController = new ProduitController();
$products = $produitController->getAllProducts();

// Récupération des catégories et sous-catégories
$getCategorie = new ModelCategorie();
$categories = $getCategorie->getAllCategorie();
$sousCategories = $getCategorie->getAllSousCategories();

// Fonction de validation pour l'upload de fichiers
function validation($file) {
    $error = false;
    $errorMessage = '';
    $filename = '';
    
    if (!empty($file["name"])) {
        $filename = $file['name'];
        $dossier_temporaire = $file['tmp_name'];
        $dossier_upload = __DIR__ . "/../../assets/images/" . $filename;
        
        $extension_du_fichier = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $extensions_autorisees = array("jpg", "jpeg", "png","JPG", "JPEG", "PNG", "webp", "WEBP");

        if (!in_array($extension_du_fichier, $extensions_autorisees)) {
            $errorMessage = "L'extension n'est pas autorisée. Utilisez JPG, JPEG ou PNG.";
            $error = true;
        }

        if (!$error && !move_uploaded_file($dossier_temporaire, $dossier_upload)) {
            $errorMessage = "Une erreur est survenue pendant l'upload du fichier";
            $error = true;
        }
    }

    return ['success' => !$error, 'message' => $errorMessage, 'filename' => $filename];
}

// Traitement de l'ajout de produit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'addProduct') {
    $data = [
        'nom' => $_POST['nom'],
        'description' => $_POST['description'],
        'prix' => $_POST['prix'],
        'quantite' => $_POST['quantite'],
        'categorie' => $_POST['categorie'],
        'sous_categorie' => $_POST['sous_categorie']
    ];

    // Validation de l'image
    $imageResult = ['success' => true];
    if (isset($_FILES['image'])) {
        $imageResult = validation($_FILES['image']);
        if ($imageResult['success'] && !empty($imageResult['filename'])) {
            $data['image'] = $imageResult['filename'];
        }
    }

    if ($imageResult['success']) {
        try {
            $produitController->addProduct(
                $data['nom'],
                $data['description'],
                $data['prix'],
                $data['quantite'],
                isset($data['image']) ? $data['image'] : null,
                $data['categorie'],
                $data['sous_categorie']
            ); // Appel à la méthode addProduct
            echo "<script>
                var message = document.createElement('div');
                message.innerText = 'Produit ajouté avec succès';
                message.style.color = 'green';
                message.style.position = 'fixed';
                message.style.top = '10px';
                message.style.left = '50%';
                message.style.transform = 'translateX(-50%)';
                message.style.backgroundColor = 'white';
                message.style.padding = '10px';
                message.style.border = '1px solid green';
                document.body.appendChild(message);
                setTimeout(function() {
                    document.body.removeChild(message);
                    window.location.href = 'admin-produits'; // Redirection vers admin-produits
                }, 5000);
            </script>";
        } catch (Exception $e) {
            $_SESSION['message'] = 'Erreur : ' . addslashes($e->getMessage());
            header('Location: ' . $_SERVER['PHP_SELF']); // Redirection pour éviter le rechargement
            exit();
        }
    } else {
        $_SESSION['message'] = 'Erreur : ' . addslashes($imageResult['message']);
        header('Location: ' . $_SERVER['PHP_SELF']); // Redirection pour éviter le rechargement
        exit();
    }
}


// Traitement de la suppression de produit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'deleteProduct') {
    $productId = $_POST['product_id'];
    
    // Récupérer le produit pour obtenir le nom de l'image
    $product = $produitController->getProductById($productId); // Assurez-vous que cette méthode existe

    // Chemin du fichier à supprimer
    $imagePath = __DIR__ . "/../../assets/images/" . $product['image'];

    try {
        // Supprimer le produit de la base de données
        $produitController->deleteProduct($productId);
        
        // Supprimer l'image du système de fichiers
        if (file_exists($imagePath)) {
            unlink($imagePath); // Supprime le fichier
        }

        $_SESSION['message'] = 'Produit supprimé avec succès.';
    } catch (Exception $e) {
        $_SESSION['message'] = 'Erreur : ' . addslashes($e->getMessage());
    }
    echo "<script>
        var message = document.createElement('div');
        message.innerText = 'Produit supprimé avec succès';
        message.style.color = 'green';
        message.style.position = 'fixed';
        message.style.top = '10px';
        message.style.left = '50%';
        message.style.transform = 'translateX(-50%)';
        message.style.backgroundColor = 'white';
        message.style.padding = '10px';
        message.style.border = '1px solid green';
        document.body.appendChild(message);
        setTimeout(function() {
            document.body.removeChild(message);
            window.location.href = 'admin-produits'; // Redirection vers admin-produits
        }, 5000);
    </script>";
}


usort($products, function($a, $b) {
    return $a['id'] - $b['id'];
});

// Affichage du message
$message = isset($_SESSION['message']) ? $_SESSION['message'] : '';
if ($message) {
    unset($_SESSION['message']); // Nettoyage du message
}

?>

<main>
    <section class="section">
        <h1 class="section-title">Gestion des Produits</h1>
        
        <?php if ($message): ?>
            <div id="message" style="color: green; margin-bottom: 20px;"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <!-- Bouton pour ajouter un produit, qui ouvre une modal -->
        <button id="btn-add-product" class="btn btn-ajouter">Ajouter un produit</button>

        <!-- Modal pour ajouter un produit -->
        <div id="addProductModal" class="modal" style="display: none;">
            <div class="modal-content">
                <span class="close" onclick="closeModal('addProductModal')">&times;</span>
                <h2>Ajouter un nouveau produit</h2>
                <form id="addProductForm" action="" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="addProduct">
                    <label for="productName">Nom du produit :</label>
                    <input type="text" name="nom" required>

                    <label for="productDescription">Description :</label>
                    <textarea name="description" required></textarea>
                    
                    <label for="productPrice">Prix :</label>
                    <input type="number" name="prix" step="0.01" required>
                    
                    <label for="productQuantity">Quantité :</label>
                    <input type="number" name="quantite" required>
                    
                    <label for="productImage">Image :</label>
                    <input type="file" name="image" required accept=".jpg,.jpeg,.png,.webp">

                    <label for="productCategory">Catégorie :</label>
                    <select name="categorie" required>
                        <?php foreach ($categories as $categorie): ?>
                            <option value="<?php echo $categorie['id_categorie']; ?>"><?php echo htmlspecialchars($categorie['nom_p']); ?></option>
                        <?php endforeach; ?>
                    </select>

                    <label for="productSubCategory">Sous-catégorie :</label>
                    <select name="sous_categorie" required>
                        <?php foreach ($sousCategories as $sousCategorie): ?>
                            <option value="<?php echo $sousCategorie['id_sousCategorie']; ?>"><?php echo htmlspecialchars($sousCategorie['nom_sc']); ?></option>
                        <?php endforeach; ?>
                    </select>

                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </form>
            </div>
        </div>

        <!-- Affichage de la table des produits ici -->
        <?php if (!empty($products)): ?>
        <table class="product-table m-t">
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
                <td><?php echo htmlspecialchars($product['nom']); ?></td>
                <td><?php echo htmlspecialchars($product['description']); ?></td>
                <td><img src="<?php echo ASSETS; ?>/images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['nom']); ?>" width="50"></td>
                <td><?php echo htmlspecialchars($product['prix']); ?> €</td>
                <td><?php echo htmlspecialchars($product['quantite']); ?></td>
                <td><?php echo htmlspecialchars($product['nom_p']); ?></td>
                <td><?php echo htmlspecialchars($product['nom_sc']); ?></td>
                <td>
                    <button class="btn btn-ajouter" onclick="openEditModal(<?php echo $product['id']; ?>)">Modifier</button>
                    <form action="" method="POST" style="display:inline;">
                        <input type="hidden" name="action" value="deleteProduct">
                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                        <button type="submit" class="btn btn-supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?');">Supprimer</button>
                    </form>

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
// Fonction pour ouvrir et fermer les modals
function openModal(modalId) {
    document.getElementById(modalId).style.display = "block";
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = "none";
}

// Ouvrir la modal pour ajouter un produit
document.getElementById('btn-add-product').onclick = function() {
    openModal('addProductModal');
};
</script>
