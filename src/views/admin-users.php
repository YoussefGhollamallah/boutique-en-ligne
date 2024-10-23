<?php
require_once __DIR__ . '/../controllers/UtilisateurController.php';

$utilisateurController = new UtilisateurController();
$utilisateurs = $utilisateurController->getAllUsers();

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
                <td>Rôle</td>
                <td>Actions</td>
            </tr>
            <?php foreach ($utilisateurs as $utilisateur): ?>
            <tr data-user-id="<?php echo $utilisateur['id']; ?>">
                <td><?php echo htmlspecialchars($utilisateur['id']); ?></td>
                <td class="editable" data-field="nom"><?php echo htmlspecialchars($utilisateur['nom']); ?></td>
                <td class="editable" data-field="prenom"><?php echo htmlspecialchars($utilisateur['prenom']); ?></td>
                <td class="editable" data-field="email"><?php echo htmlspecialchars($utilisateur['email']); ?></td>
                <td class="editable" data-field="nom_role"><?php echo htmlspecialchars($utilisateur['nom_role']); ?></td>
                <td>
                    <button class="btn-edit">Modifier</button>
                    <button class="btn-save" style="display: none;">Valider</button>
                    <button class="btn-cancel" style="display: none;">Annuler</button>
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

<script src="<?php echo ASSETS; ?>/js/admin-users.js"></script>