<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../controllers/UtilisateurController.php';

$user = new UtilisateurController();

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $entered_code = htmlspecialchars(trim($_POST['verification_code']));

    if ($entered_code == $_SESSION['verification_code']) {
        // Complete the registration process
        $prenom = $_SESSION['prenom'];
        $nom = $_SESSION['nom'];
        $email = $_SESSION['email'];
        $hashedPassword = $_SESSION['mot_de_passe'];

        $user->addUser($prenom, $nom, $email, $hashedPassword);

        // Clear the session variables
        unset($_SESSION['prenom']);
        unset($_SESSION['nom']);
        unset($_SESSION['email']);
        unset($_SESSION['mot_de_passe']);
        unset($_SESSION['verification_code']);
        unset($_SESSION['attempts']);

        // Redirect to the profile page
        $_SESSION['user'] = $user->userConnexion($email, $hashedPassword);
        header('Location: profil');
        exit();
    } else {
        $message = 'Code de vérification incorrect.';
        $_SESSION['attempts'] += 1;

        if ($_SESSION['attempts'] >= 3) {
            // Clear the session variables after 3 failed attempts
            unset($_SESSION['prenom']);
            unset($_SESSION['nom']);
            unset($_SESSION['email']);
            unset($_SESSION['mot_de_passe']);
            unset($_SESSION['verification_code']);
            unset($_SESSION['attempts']);

            $message = 'Trop de tentatives échouées. Veuillez recommencer le processus d\'inscription.';
        }
    }
}
?>


    <main class="main-form">
        <div class="container-form">
            <h2>Vérification</h2>
            <?php if ($message): ?>
                <p><?php echo $message; ?></p>
            <?php endif; ?>
            <form action="" method="post">
                <label for="verification_code">Code de vérification</label>
                <input type="text" name="verification_code" id="verification_code" required>
                <button type="submit">Vérifier</button>
            </form>
        </div>
    </main>
