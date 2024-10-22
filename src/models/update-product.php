<?php
require_once __DIR__ . '/../models/ModelProduit.php';

function validation($file)
{
    $error = false;
    $errorMessage = '';
    
    if (!empty($file["name"])) {
        $nom_du_fichier = $file['name'];
        $dossier_temporaire = $file['tmp_name'];
        $dossier_upload = "assets/images/".$nom_du_fichier;

        $extension_du_fichier = strtolower(pathinfo($nom_du_fichier, PATHINFO_EXTENSION));
        $extensions_autorisees = array("jpg", "jpeg", "png");

        if (!in_array($extension_du_fichier, $extensions_autorisees)) {
            $errorMessage = "L'extension n'est pas autorisée. Utilisez JPG, JPEG ou PNG.";
            $error = true;
        }

        if (!$error && !move_uploaded_file($dossier_temporaire, $dossier_upload)) {
            $errorMessage = "Une erreur est survenue pendant l'upload du fichier";
            $error = true;
        }
    }

    return ['success' => !$error, 'message' => $errorMessage, 'filename' => $error ? '' : $nom_du_fichier];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'id' => $_POST['id'],
        'nom' => $_POST['nom'],
        'description' => $_POST['description'],
        'prix' => $_POST['prix'],
        'quantite' => $_POST['quantite']
    ];

    $imageResult = ['success' => true];
    if (isset($_FILES['file'])) {
        $imageResult = validation($_FILES['file']);
        if ($imageResult['success']) {
            $data['image'] = $imageResult['filename'];
        }
    }

    if ($imageResult['success']) {
        $modelProduit = new ModelProduit();
        try {
            $success = $modelProduit->updateProduct($data['id'], $data);
            echo json_encode(['success' => $success, 'newImage' => $data['image'] ?? null]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['success' => false, 'message' => $imageResult['message']]);
    }
}
