<?php
session_start();
?>

<h2>Confirmation de Commande</h2>

<?php if (isset($_GET['status']) && $_GET['status'] == 'success') { ?>
    <p>Merci pour votre commande ! Votre paiement a été traité avec succès.</p>
    <p><a href="panier">Retourner au panier</a></p>
<?php } else { ?>
    <p>Une erreur est survenue lors de votre paiement. Veuillez réessayer.</p>
    <p><a href="panier">Retourner au panier</a></p>
<?php } ?>

