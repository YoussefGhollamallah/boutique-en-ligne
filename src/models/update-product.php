<?php
require_once __DIR__ . '/src/models/ModelProduit.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifie si les données viennent d'un formulaire avec téléchargement de fichier
    if (isset($_FILES['image'])) {
        $image = $_FILES['image']['name'];
        $target_dir = "../assets/images/";
        $target_file = $target_dir . basename($image);

        // Validation de l'image (formats autorisés)
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        if (in_array($imageFileType, ['jpg', 'jpeg', 'png'])) {
            // Déplacer l'image téléchargée dans le répertoire cible
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                // L'image a été téléchargée avec succès
                $data['image'] = $image;  // Assigner l'image au tableau de données
            } else {
                echo json_encode(['success' => false, 'message' => 'Échec du téléchargement de l\'image']);
                exit;
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Format d\'image non autorisé']);
            exit;
        }
    }

    // Récupérer les autres données du formulaire (id, nom, description, etc.)
    $data = [
        'id' => $_POST['id'],
        'nom' => $_POST['nom'],
        'description' => $_POST['description'],
        'prix' => $_POST['prix'],
        'quantite' => $_POST['quantite'],
        'categorie_id' => $_POST['categorie'],
        'sous_categorie_id' => $_POST['sous_categorie'],
    ];

    // Instancier le modèle et appeler la méthode de mise à jour
    $modelProduit = new ModelProduit();
    $success = $modelProduit->updateProduct($data['id'], $data);

    echo json_encode(['success' => $success]);
}
