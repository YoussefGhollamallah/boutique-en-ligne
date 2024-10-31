<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id'])) {
    header('Location: connexion');
    exit;
}

$panierController = new PanierController();
$userId = $_SESSION['user_id']; // Récupérer l'ID utilisateur

?>

<h2>Confirmation de Commande</h2>

<?php if (isset($_GET['status']) && $_GET['status'] == 'success') { 
    // Valider la commande et stocker les données
    try {
        $panierController->validerCommande($userId); // Appeler la méthode pour valider la commande
        $panierController->supprimerProduitsCochesDuPanier(); // Supprimer les produits cochés du panier après la validation
?>
    <p>Merci pour votre commande ! Votre paiement a été traité avec succès.</p>
    <p>Les produits achetés ont été retirés de votre panier.</p>
    <p><a class="btn btn-ajouter" href="panier">Retourner au panier</a></p>
<?php 
    } catch (Exception $e) {
?>
    <p>Une erreur est survenue lors de votre commande : <?php echo htmlspecialchars($e->getMessage()); ?></p>
    <p><a class="btn btn-ajouter" href="panier">Retourner au panier</a></p>
<?php 
    }
} else { ?>
    <p>Une erreur est survenue lors de votre paiement. Veuillez réessayer.</p>
    <p><a class="btn btn-ajouter" href="panier">Retourner au panier</a></p>
<?php } ?>
