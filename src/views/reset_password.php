<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifiez si le champ new_password est défini
    $new_password = isset($_POST['new_password']) ? trim($_POST['new_password']) : '';

    if (!empty($new_password)) {
        $new_password = htmlspecialchars($new_password);
        
        // Utilisation du contrôleur pour mettre à jour le mot de passe
        $user = new UtilisateurController();
        $updateMessage = $user->resetPassword($_SESSION['email'], $new_password);

        // Vérifiez le retour de la méthode resetPassword
        if ($updateMessage === "Le mot de passe a été mis à jour avec succès.") {
            // Réinitialiser les variables de session
            unset($_SESSION['reset_code']);
            unset($_SESSION['email']);
            
            // Rediriger vers la page de connexion
            header('Location: connexion');
            exit();
        } else {
            echo "Erreur lors de la mise à jour du mot de passe. " . $updateMessage;
        }
    } else {
        echo "Le mot de passe ne peut pas être vide.";
    }
}
?>
<form method="POST" action="">
    <input type="password" name="new_password" required placeholder="Nouveau mot de passe">
    <button type="submit">Réinitialiser le mot de passe</button>
</form>
