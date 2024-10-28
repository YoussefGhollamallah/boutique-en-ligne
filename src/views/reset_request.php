<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../controllers/UtilisateurController.php';

// Inclure PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$user = new UtilisateurController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    $email = htmlspecialchars(trim($_POST['email']));

    if ($action === 'reset_request') {
        if (!empty($email)) {
            // Générer un code de réinitialisation sécurisé
            $reset_code = random_int(100000, 999999);

            // Configuration de PHPMailer
            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com'; 
                $mail->SMTPAuth   = true;
                $mail->Username   = 'anna.pixel.plush@gmail.com'; // Remplace par ton adresse Gmail
                $mail->Password   = 'y q g l b j i y l o q z c o a w'; // Remplace par ton mot de passe ou mot de passe d'application
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587;
                $mail->CharSet = 'UTF-8';
                $mail->Encoding = 'base64';

                // Destinataire
                $mail->setFrom('ghollamallahyoussef@gmail.com', 'Pixel Plush'); 
                $mail->addAddress($email);

                // Contenu de l'email
                $mail->isHTML(true);
                $mail->Subject = 'Demande de réinitialisation de mot de passe';
                $mail->Body    = "Bonjour,<br> Vous avez demandé une réinitialisation de votre mot de passe. Voici votre code : " . $reset_code . "<br> Nous vous remercions de votre confiance.";

                // Envoi de l'email
                $mail->send();

                // Stocker le code de réinitialisation dans la session
                $_SESSION['reset_code'] = $reset_code;
                $_SESSION['email'] = $email;

                // Rediriger vers la page de vérification
                header('Location: verification_password');
                exit;

            } catch (Exception $e) {
                echo "Erreur lors de l'envoi de l'email. PHPMailer Erreur : {$mail->ErrorInfo}";
            }
        } else {
            echo "L'email est requis.";
        }
    }
}

?>
<main class="main-form">
    <div class="container-form">
        <h2>Réinitialisation de mot de passe</h2>
        <form class="form" action="" method="post">
            <input type="hidden" name="action" value="reset_request">
            <div>
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required>
            </div>
            <button class="btn btn-ajouter" type="submit">Envoyer le code de réinitialisation</button>
        </form>
        <div style="margin-top: 10px;">
            <a href="connexion" class="btn btn-secondary">Retour à la connexion</a>
        </div>
    </div>
</main>
