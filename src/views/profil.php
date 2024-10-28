<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user'])) {
    header('Location: connexion');
    exit;
}

require_once __DIR__ . "/../controllers/AdresseController.php";

$adresseController = new AdresseController();
$adresse = $adresseController->getAdresse($_SESSION["user"]["id"])

?>

<main>
    <?php if (isset($_SESSION["user"]["role_id"]) && $_SESSION["user"]["role_id"] == 2) : ?>
        <section>
            <h2>Mon Profil</h2>
        </section>
        <section>
            <h3>Mes informations</h3>
            <div class="profil">
                <div>
                    <p>Prénom : <?php echo $_SESSION['user']['prenom']; ?></p>
                    <p>Nom : <?php echo $_SESSION['user']['nom']; ?></p>
                    <p>Email : <?php echo $_SESSION['user']['email']; ?></p>
                </div>
            </div>
        </section>
        <section>
        <div class="profil">
                <div>
                    <?php if ($adresse): ?>
                        <p>Adresse : <?php echo $adresse['adresse']; ?></p>
                        <p>Ville : <?php echo $adresse['ville']; ?></p>
                        <p>Code Postal : <?php echo $adresse['code_postal']; ?></p>
                        <p>Pays : <?php echo $adresse['pays']; ?></p>
                    <?php else: ?>
                        <p>Aucune adresse enregistrée.</p>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    <?php elseif (isset($_SESSION["user"]["role_id"]) && $_SESSION["user"]["role_id"] == 1) : ?>
        <section>
            <h2>Mon Profil</h2>
        </section>
        <section>
            <h3>Mes informations</h3>
            <div class="profil">
                <div>
                    <p>Prénom : <?php echo $_SESSION['user']['prenom']; ?></p>
                    <p>Nom : <?php echo $_SESSION['user']['nom']; ?></p>
                    <p>Email : <?php echo $_SESSION['user']['email']; ?></p>
                </div>
            </div>
        </section>
        <section>
            <h3>Mon rôle</h3>
            <div class="profil">
                <div>
                    <p>Rôle : Administrateur</p>
                </div>
            </div>
        </section>
    <?php endif; ?>
</main>