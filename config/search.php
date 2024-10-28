<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json'); 

$search = $_GET['search'] ?? '';

try {
    $bdd = new PDO('mysql:host=193.203.168.103;dbname=u126908064_pixel_plush', 'u126908064_pixel_plush', 'Plateformeur_13');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $bdd->prepare("SELECT * FROM Produit WHERE nom LIKE :search");
    $stmt->execute([':search' => '%' . $search . '%']);
    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($res);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>