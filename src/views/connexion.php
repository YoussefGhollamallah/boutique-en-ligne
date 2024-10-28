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
    $password = htmlspecialchars(trim($_POST['password']));

    if ($action === 'register') {
        $prenom = htmlspecialchars(trim($_POST['prenom']));
        $nom = htmlspecialchars(trim($_POST['nom']));
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Vérification de l'unicité de l'email
        if ($user->emailExists($email)) {
            $error = "Cet email est déjà utilisé.";
        } else {
            // Générer un code de vérification sécurisé
            $verification_code = random_int(100000, 999999);

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
                $mail->Subject = 'Code de vérification';
                $mail->Body    = "Bonjour ". $prenom . ', votre code de vérification est : ' . $verification_code . "<br> Nous vous remercions de votre inscription sur notre site Pixel Plush";

                // Envoi de l'email
                $mail->send();

                // Stocker les informations utilisateur et le code de vérification dans la session
                $_SESSION['prenom'] = $prenom;
                $_SESSION['nom'] = $nom;
                $_SESSION['email'] = $email;
                $_SESSION['mot_de_passe'] = $hashedPassword;
                $_SESSION['verification_code'] = $verification_code;
                $_SESSION['attempts'] = 0; // Initialisation des tentatives

                // Rediriger vers la page de vérification
                header('Location: verification');
                exit;

            } catch (Exception $e) {
                echo "Erreur lors de l'envoi de l'email. PHPMailer Erreur : {$mail->ErrorInfo}";
            }
        }
    } elseif ($action === 'login') {
        if (!empty($email) && !empty($password)) {
            $userData = $user->userConnexion($email, $password);
            if ($userData) {
                $_SESSION['user'] = $userData;
                header('Location: profil');
                exit();
            } else {
                $error = "Email ou mot de passe incorrect.";
            }
        } else {
            $error = "Tous les champs sont obligatoires.";
        }
    }
}

if (isset($_SESSION['user'])) {
    header('Location: profil');
    exit();
}
?>
<main class="main-form">
    <div class="container-form">
        <div class="form-container" id="register-form">
            <button class="btn btn-primary form-button" onclick="switchForm('login')">Déjà un compte? Connectez-vous</button>
            <h2>Inscription</h2>
            <form class="form" action="" method="post">
                <?php if (isset($error) && $action === 'register'): ?>
                    <p style="color:red;"><?php echo $error; ?></p>
                <?php endif; ?>
                <input type="hidden" name="action" value="register">
                <div>
                    <label for="prenom">Prénom</label>
                    <input type="text" name="prenom" id="prenom" required>
                </div>
                <div>
                    <label for="nom">Nom</label>
                    <input type="text" name="nom" id="nom" required>
                </div>
                <div>
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" required>
                </div>
                <div>
                    <label for="password">Mot de passe</label>
                    <input type="password" name="password" id="password" required>
                </div>
                <button class="btn btn-ajouter" type="submit">S'inscrire</button>
            </form>
        </div>

        <div class="form-container" id="login-form" style="display: none;">
            <button class="btn btn-primary form-button" onclick="switchForm('register')">Pas encore de compte? Inscrivez-vous</button>
            <h2>Connexion</h2>
            <form action="" class="form" method="post">
                <?php if (isset($error) && $action === 'login'): ?>
                    <p style="color:red;"><?php echo $error; ?></p>
                <?php endif; ?>
                <input type="hidden" name="action" value="login">
                <div>
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" required>
                </div>
                <div>
                    <label for="password">Mot de passe</label>
                    <input type="password" name="password" id="password" required>
                </div>
                <button class="btn btn-ajouter" type="submit">Se connecter</button>
            </form>
        </div>
    </div>
</main>

<script>
    function switchForm(form) {
        if (form === 'register') {
            document.getElementById('register-form').style.display = 'block';
            document.getElementById('login-form').style.display = 'none';
        } else if (form === 'login') {
            document.getElementById('register-form').style.display = 'none';
            document.getElementById('login-form').style.display = 'block';
        }
    }
</script>
