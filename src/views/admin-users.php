<?php
// Assurez-vous d'inclure vos contrôleurs
require_once __DIR__ . '/../controllers/UtilisateurController.php';
require_once __DIR__ . '/../controllers/AdresseController.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user'])) {
    header('Location: connexion');
    exit;
}

if (isset($_SESSION["user"]["role_id"]) && $_SESSION["user"]["role_id"] != 1) {
    header('Location: index');
    exit;
}

$utilisateurController = new UtilisateurController();
$adressesController = new AdresseController();
$utilisateurs = $utilisateurController->getAllUsers();
$roles = $utilisateurController->getRoles();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['userId'])) {
        $userId = $_POST['userId'];

        // Suppression de l'utilisateur
        $utilisateurDelete = new ModelUtilisateur();
        $utilisateurDelete->deleteUserById($userId);

        $_SESSION['message'] = "Utilisateur supprimé avec succès"; // Stockez le message dans la session
        header("Location: admin-users"); // Corrigez la redirection
        exit;
    } else {
        $_SESSION['message'] = "Utilisateur non trouvé"; // Message d'erreur
    }
}
?>
<link rel="stylesheet" href="assets/css/admin-users.css">

<main>
    <section class="section">
        <h1 class="section-title">Gestion des Utilisateurs</h1>

        <?php 
        // Affichez le message si défini
        if (isset($_SESSION['message'])) {
            echo $_SESSION['message'];
            unset($_SESSION['message']); // Effacez le message après affichage
        }
        ?>

        <?php if (!empty($utilisateurs)): ?>
            <table class="user-table">
                <tr class="line-1">
                    <td>ID</td>
                    <td>Nom</td>
                    <td>Prénom</td>
                    <td>Email</td>
                    <td>Adresse</td>
                    <td>Rôle</td>
                    <td>Actions</td>
                </tr>
                <?php foreach ($utilisateurs as $utilisateur): ?>
                    <?php
                    $adresses = $adressesController->getAdresse($utilisateur['id']);
                    ?>
                    <tr data-user-id="<?php echo $utilisateur['id']; ?>">
                        <td><?php echo htmlspecialchars($utilisateur['id']); ?></td>
                        <td><?php echo htmlspecialchars($utilisateur['nom']); ?></td>
                        <td><?php echo htmlspecialchars($utilisateur['prenom']); ?></td>
                        <td><?php echo htmlspecialchars($utilisateur['email']); ?></td>
                        <td>
                            <?php
                            if ($adresses === null) {
                                echo "";
                            } else {
                                echo htmlspecialchars($adresses["adresse"]) . '<br>' . htmlspecialchars($adresses['adresse_complement']) . '<br>' . htmlspecialchars($adresses["code_postal"]) . ', ' . htmlspecialchars($adresses["ville"]) . ', ' . htmlspecialchars($adresses["pays"]);
                            }
                            ?>
                        </td>
                        <td><?php echo htmlspecialchars($utilisateur['nom_role']); ?></td>
                        <td>
                            <form action="" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">
                                <input type="hidden" name="userId" value="<?php echo $utilisateur['id']; ?>">
                                <button type="submit" class="btn-supprimer btn">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>Aucun utilisateur n'a été trouvé.</p>
        <?php endif; ?>
    </section>
</main>

<script>
    // Votre code JavaScript ici
</script>
