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

$utilisateurDelete = new ModelUtilisateur();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['userId'])) {
        $userId = $_POST['userId'];

        // Suppression de l'utilisateur
        $utilisateurDelete->deleteUserById($userId);

        // Redirection après suppression
        header('Location: admin-users');
        exit;
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['userId'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $adresse = $_POST['adresse'];
    $adresse_complement = $_POST['adresse_complement'];
    $code_postal = $_POST['code_postal'];
    $ville = $_POST['ville'];
    $pays = $_POST['pays'];
    $role_id = $_POST['nom_role'];

    // Mettre à jour l'utilisateur
    $utilisateurController->updateUser($userId, $nom, $prenom, $email, $role_id);

    // Mettre à jour l'adresse
    $adressesController->updateAdresse($userId, $adresse, $adresse_complement, $code_postal, $ville, $pays);
}
?>
<link rel="stylesheet" href="assets/css/admin-users.css">

<main>
    <section class="section">
        <h1 class="section-title">Gestion des Utilisateurs</h1>

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
                            <button type="submit" class="btn-delete btn">Supprimer</button>
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

</script>
