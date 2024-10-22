<?php
require_once __DIR__ . '/../models/ModelProduit.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'id' => $_POST['id'],
        'nom' => $_POST['nom'],
        'description' => $_POST['description'],
        'prix' => $_POST['prix'],
        'quantite' => $_POST['quantite']
    ];

    $modelProduit = new ModelProduit();
    try {
        $success = $modelProduit->updateProduct($data['id'], $data);
        echo json_encode(['success' => $success]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}
