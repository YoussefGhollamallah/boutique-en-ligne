<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user'])) {
    header('Location: connexion');
    exit;
}

?>

<h2>Confirmation de Commande</h2>

<?php if (isset($_GET['status']) && $_GET['status'] == 'success') { ?>
    <p>Merci pour votre commande ! Votre paiement a été traité avec succès.</p>
    <p><a class ="btn btn-ajouter" href="panier">Retourner au panier</a></p>
<?php } else { ?>
    <p>Une erreur est survenue lors de votre paiement. Veuillez réessayer.</p>
    <p><a class ="btn btn-ajouter" href="panier">Retourner au panier</a></p>
<?php } ?>

