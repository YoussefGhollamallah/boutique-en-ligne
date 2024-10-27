<?php

require_once __DIR__ . '/../controllers/UtilisateurController.php';

$user = new UtilisateurController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));

    if ($action === 'register') {
        $prenom = htmlspecialchars(trim($_POST['prenom']));
        $nom = htmlspecialchars(trim($_POST['nom']));
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        if (!empty($prenom) && !empty($nom) && !empty($email) && !empty($hashedPassword)) {
            $user->addUser($prenom, $nom, $email, $hashedPassword);
            header('Location: connexion');
            exit();
        } else {
            echo "Tous les champs sont obligatoires.";
        }
    } elseif ($action === 'login') {
        if (!empty($email) && !empty($password)) {
            if ($user->userConnexion($email, $password)) {
                header('Location: /profil');
                exit();
            } else {
                echo "Email ou mot de passe incorrect.";
            }
        } else {
            echo "Tous les champs sont obligatoires.";
        }
    }
}
?>
<main class="main-form">

    
    <div class="container-form ">
        <div class="form-container" id="register-form">
            <h2>Inscription</h2>
            <form class="form" action="" method="post">
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
                    <br>
                    <input type="password" name="password" id="password" required>
                    
                </div>
                <button class="btn btn-ajouter" type="submit">S'inscrire</button>
            </form>
            <button class="btn btn-primary form-button" onclick="switchForm('login')">Déjà un compte? Connectez-vous</button>
        </div>

        <div class="form-container" id="login-form" style="display: none;">
            <h2>Connexion</h2>
            <form action="" class="form" method="post">
                
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
            <button class="btn btn-primary form-button" onclick="switchForm('register')">Pas encore de compte? Inscrivez-vous</button>
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