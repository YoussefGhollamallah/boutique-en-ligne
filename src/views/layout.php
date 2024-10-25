<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Peralta&display=swap" rel="stylesheet">
    <link rel="icon" type="favicon" href="<?php echo ASSETS; ?>images/favicon.ico">
    <link rel="stylesheet" href="<?php echo ASSETS; ?>css/styles.css">
    <link rel="stylesheet" href="<?php echo ASSETS; ?>css/admin-users.css">
    <link rel="stylesheet" href="<?php echo ASSETS; ?>css/admin-produits.css">
    <title><?php echo $title ?? 'Pixel Plush'; ?></title>
</head>

<body>

    <!-- Lien de l'ancre en haut de la page -->
    <a id="top"></a>

    <!-- HEADER -->
    <header class="flex space-between center vertical-center">

        <div class="off-screen-menu hide_desktop">
            <ul>
                <li>
                    <a class="#" href="<?php echo BASE_URL; ?>panier">Panier
                        <img class="hw-50px" src="<?php echo ASSETS; ?>/images/panier.png" alt="panier logo">
                    </a>
                </li>
                <li>
                    <a href="#">Rechercher
                        <img class="hw-50px" src="<?php echo ASSETS; ?>/images/loupe.png" alt="loupe logo">
                    </a>
                </li>
            </ul>
        </div>

        <nav>
            <div class="ham-menu">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </nav>
        <a href="<?php echo BASE_URL; ?>">
            <img src="<?php echo ASSETS; ?>/images/logo.png" class="logo" alt="logo">
        </a>
        <h1 class="hide_mobile">Pixel Plush</h1>
        <nav class="flex space-center vertical-center gap">
            <input class="hide_mobile" type="text" placeholder="Rechercher">
            <a class="hide_mobile" href="<?php echo BASE_URL; ?>panier">
                <img class="hw-50px" src="<?php echo ASSETS; ?>/images/panier.png" alt="panier logo">
                Panier
            </a>
            <a class="flex column vertical-center" href="<?php echo BASE_URL; ?>connexion">
                <img class="hw-50px" src="<?php echo ASSETS; ?>/images/utilisateur.png" alt="utilisateur logo">
                <?php
                if (isset($_SESSION['user'])) {
                    echo "Bonjour" . $_SESSION['user']['prenom'];
                } else {
                    echo 'Connexion';
                }
                ?>
            </a>
        </nav>
    </header>

    <!-- BANDEAU -->
    <section class="section">
        <h2>Retrouve tes personnages préférés à câliner !</h2>
    </section>

    <main>
        <!-- CONTENU DES PAGES -->
        <?php echo $contentPage; ?>
    </main>

    <!-- Ancre -->
    <a href="#top" class="ancre" id="scrollToTop">↑</a>

    <footer>
        <p>&copy; Pixel Plush 2024</p>
    </footer>
    <script src="<?php echo ASSETS; ?>/js/burger.js"></script>
    <script src="<?php echo ASSETS; ?>/js/ancre.js"></script>

</body>

</html>