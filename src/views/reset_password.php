<?php
session_start(); // Assurez-vous de démarrer la session

// reset_password.php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_password = htmlspecialchars(trim($_POST['new_password']));
    
    if (!empty($new_password)) {
        $hashedPassword = password_hash($new_password, PASSWORD_DEFAULT);
        
        // Ici, vous devez mettre à jour le mot de passe dans la base de données
        // Exemple : $user->updatePassword($_SESSION['email'], $hashedPassword);

        // Vérifiez si la mise à jour a réussi
        // Supposons que $updateSuccess soit vrai si la mise à jour a réussi
        if ($updateSuccess) {
            // Réinitialiser les variables de session
            unset($_SESSION['reset_code']);
            unset($_SESSION['email']);
            
            // Rediriger vers la page de connexion
            header('Location: connexion');
            exit();
        } else {
            echo "Erreur lors de la mise à jour du mot de passe. Veuillez réessayer.";
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
