<?php
require_once __DIR__ . '/../controllers/UtilisateurController.php';
require_once __DIR__ . '/../controllers/AdresseController.php';

$utilisateurController = new UtilisateurController();
$adressesController = new AdresseController();
$utilisateurs = $utilisateurController->getAllUsers();
$roles = $utilisateurController->getRoles();

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

    // Répondre
    echo "OK";
    exit;
}

?>
<link rel="stylesheet" href="assets/css/admin-users.css">

<main>
    <section class="section">
        <h1 class="section-title">Gestion des Utilisateurs</h1>

        <?php if (!empty($utilisateurs)): ?>
            <!-- Tableau -->
            <table class="user-table">
                <!-- Ligne 1 : En-têtes -->
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
                            // Affiche l'adresse si elle existe, sinon champs vides
                            if ($adresses === null) {
                                echo "";
                            } else {
                                echo htmlspecialchars($adresses["adresse"]) . '<br>'  . htmlspecialchars($adresses['adresse_complement']) . '<br>' . htmlspecialchars($adresses["code_postal"]) . ', ' . htmlspecialchars($adresses["ville"]) . ', ' . htmlspecialchars($adresses["pays"]);
                            }
                            ?>
                        </td>
                        <td><?php echo htmlspecialchars($utilisateur['nom_role']); ?></td>
                        <td>
                            <button class="btn-edit" data-user-id="<?php echo $utilisateur['id']; ?>">Modifier</button>
                            <a href="delete-user.php?id=<?php echo $utilisateur['id']; ?>" class="btn btn-supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>Aucun utilisateur n'a été trouvé.</p>
        <?php endif; ?>
    </section>
</main>

<!-- Modal -->
<div id="userModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Modifier Utilisateur</h2>
        <form id="userForm">
            <input type="hidden" id="userId" name="userId">
            <label for="nom">Nom:</label>
            <input type="text" id="nom" name="nom">
            <label for="prenom">Prénom:</label>
            <input type="text" id="prenom" name="prenom">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email">
            <label for="adresse">Adresse:</label>
            <input type="text" id="adresse" name="adresse">
            <label for="adresse_complement">Complément d'adresse:</label>
            <input type="text" id="adresse_complement" name="adresse_complement">
            <label for="code_postal">Code Postal:</label>
            <input type="text" id="code_postal" name="code_postal">
            <label for="ville">Ville:</label>
            <input type="text" id="ville" name="ville">
            <label for="pays">Pays:</label>
            <input type="text" id="pays" name="pays">
            <label for="nom_role">Rôle:</label>
            <select id="nom_role" name="nom_role">
                <?php foreach ($roles as $role): ?>
                    <option value="<?php echo $role['id_role']; ?>"><?php echo $role['id_role'] . ' - ' . $role['nom_role']; ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="btn btn-ajouter">Valider</button>
            <button type="button" id="cancel" class="btn btn-supprimer">Annuler</button>
        </form>
    </div>
</div>

<!-- Rôles en JSON dans un élément caché -->
<div id="rolesData" style="display: none;"><?php echo json_encode($roles); ?></div>

<script src="assets/js/admin-users.js"></script>