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
$adresse = $adresseController->getAdresse($_SESSION["user"]["id"]);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $adresse = htmlspecialchars(trim($_POST['adresse']));
    $adresse_complement = htmlspecialchars(trim($_POST["adresse_complement"]));
    $ville = htmlspecialchars(trim($_POST['ville']));
    $code_postal = htmlspecialchars(trim($_POST['code_postal']));
    $pays = htmlspecialchars(trim($_POST['pays']));

    if ($adresseController->getAdresse($_SESSION["user"]["id"])) {
        $adresseController->updateAdresse($_SESSION["user"]["id"], $adresse, $adresse_complement, $ville, $code_postal, $pays);
    } else {
        $adresseController->addAdresse($_SESSION["user"]["id"], $adresse, $adresse_complement, $ville, $code_postal, $pays);
    }

    header('Location: profil');
    exit();
}

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
            <h3>Mon Adresse</h3>
            <div class="profil">
                <div>
                    <?php if ($adresse): ?>
                        <p>Adresse : <?php echo $adresse['adresse']; ?></p>
                        <p>Adresse Complémentaire : <?php echo $adresse["adresse_complement"]; ?></p>
                        <p>Ville : <?php echo $adresse['ville']; ?></p>
                        <p>Code Postal : <?php echo $adresse['code_postal']; ?></p>
                        <p>Pays : <?php echo $adresse['pays']; ?></p>
                        <button onclick="openModal()">Modifier Adresse</button>
                    <?php else: ?>
                        <p>Aucune adresse enregistrée.</p>
                        <button onclick="openModal()">Ajouter Adresse</button>
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
            <h3>Mon Adresse</h3>
            <div class="profil">
                <div>
                    <?php if ($adresse): ?>
                        <p>Adresse : <?php echo $adresse['adresse']; ?></p>
                        <p>Adresse Complémentaire : <?php echo $adresse["adresse_complement"]; ?></p>
                        <p>Ville : <?php echo $adresse['ville']; ?></p>
                        <p>Code Postal : <?php echo $adresse['code_postal']; ?></p>
                        <p>Pays : <?php echo $adresse['pays']; ?></p>
                        <button onclick="openModal()">Modifier Adresse</button>
                    <?php else: ?>
                        <p>Aucune adresse enregistrée.</p>
                        <button onclick="openModal()">Ajouter Adresse</button>
                    <?php endif; ?>
                </div>
            </div>
        </section>
        <section>
            <h3>Mon rôle</h3>
            <div class="profil">
                <div>
                    <p>Rôle : Administrateur</p>
                    <a class="btn btn-ajouter" href="admin-users">Gestion User</a>
                    <a class="btn btn-ajouter" href="admin-produits">Gestion Produit</a>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- Modal -->
    <div id="modal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Ajouter / Modifier Adresse</h2>
            <form action="" method="post">
                <div>
                    <label for="adresse">Adresse</label>
                    <input type="text" name="adresse" id="adresse" value="<?php echo $adresse['adresse'] ?? ''; ?>" required>
                </div>
                <div>
                    <label for="adresse_complement">Adresse Complémentaire</label>
                    <input type="text" name="adresse_complement" id="adresse_complement" value="<?php echo $adresse['adresse_complement'] ?? ''; ?>" required>
                </div>
                <div>
                    <label for="ville">Ville</label>
                    <input type="text" name="ville" id="ville" value="<?php echo $adresse['ville'] ?? ''; ?>" required>
                </div>
                <div>
                    <label for="code_postal">Code Postal</label>
                    <input type="text" name="code_postal" id="code_postal" value="<?php echo $adresse['code_postal'] ?? ''; ?>" required>
                </div>
                <div>
                    <label for="pays">Pays</label>
                    <input type="text" name="pays" id="pays" value="<?php echo $adresse['pays'] ?? ''; ?>" required>
                </div>
                <button class="btn btn-ajouter" type="submit">Enregistrer</button>
            </form>
        </div>
    </div>
</main>

<script src="<?php echo ASSETS;?>js/modal.js"></script>

<style>
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0,0,0,0.4);
    }

    .modal-content {
        background-color: #fefefe;
        margin: 10% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 50%;
        box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        border-radius: 10px;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    .modal-content form div {
        margin-bottom: 15px;
    }

    .modal-content form label {
        display: block;
        margin-bottom: 5px;
    }

    .modal-content form input {
        width: 80%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .modal-content form button {
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        background-color: #007BFF;
        color: #fff;
        cursor: pointer;
    }

    .modal-content form button:hover {
        background-color: #0056b3;
    }
</style>