<?php

// Démarrer la session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Vérifiez que les variables de session existent
if (!isset($_SESSION['reset_code']) || !isset($_SESSION['email'])) {
    // Gérer l'erreur : rediriger ou afficher un message
    header('Location: reset_request'); // Rediriger vers la page de demande de réinitialisation
    exit();
}

// Récupérer le code de réinitialisation et l'email
$reset_code = $_SESSION['reset_code'];
$email = $_SESSION['email'];

?>

<main class="main-form">
    <div class="container-form">
        <h2>Vérification du code de réinitialisation</h2>
        <form action="reset_password" method="post">
            <div>
                <label for="reset_code">Code de réinitialisation</label>
                <input type="text" name="reset_code" id="reset_code" required>
            </div>
            <button class="btn btn-ajouter" type="submit">Vérifier le code</button>
        </form>
    </div>
</main>
