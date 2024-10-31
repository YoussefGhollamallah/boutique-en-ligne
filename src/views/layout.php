<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function deconnexion()
{
    session_unset();
    session_destroy();
    header('Location:'. BASE_URL . 'index');
    exit();
}

if (isset($_GET['action']) && $_GET['action'] === 'deconnexion') {
    deconnexion();
}

?>

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
    <header class="flex space-around center vertical-center">

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
            <!-- Champ de recherche avec l'identifiant `search` pour autocomplétion -->
            <div class="search-container">
            <input class="hide_mobile" id="search" onkeydown="searchKeywords()" type="text" name="search" placeholder="Rechercher">
            <div id="suggestion" class="suggestion-box"></div>
        </div>
            <a class="hide_mobile panier" href="<?php echo BASE_URL; ?>panier">
                <img class="hw-50px" src="<?php echo ASSETS; ?>/images/panier.png" alt="panier logo">
                Panier
            </a>
            <div class="flex column vertical-center profil-container">
                <img class="hw-50px profil-img" src="<?php echo ASSETS; ?>/images/utilisateur.png" alt="utilisateur logo">
                <div class="profil-menu">
                    <?php if (isset($_SESSION['user'])): ?>
                        <a href="<?php echo BASE_URL; ?>profil">Profil</a>
                        <a href="?action=deconnexion">Déconnexion</a>
                    <?php else: ?>
                        <a href="<?php echo BASE_URL; ?>connexion">Connexion</a>
                    <?php endif; ?>
                </div>
            </div>


        </nav>

    </header>

    <!-- BANDEAU -->
    <section class="section">
        <?php if (isset($_SESSION['user'])): ?>
            <h2>Bienvenue <?php echo $_SESSION['user']['prenom']; ?>, retrouve tes personnages préférés à câliner !</h2>
        <?php else: ?>
            <h2>Retrouve tes personnages préférés à câliner !</h2>
        <?php endif; ?>
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
    <script src="<?php echo ASSETS; ?>/js/autocompletion.js"></script>
    <script src="<?php echo ASSETS;?>/js/detail.js"></script>
    <script src="<?php echo ASSETS;?>/js/panier.js"></script>
    <script src="<?php echo ASSETS; ?>js/filter.js"></script>
    <script src="<?php echo ASSETS; ?>js/carousel.js"></script>
    <script src="<?php echo ASSETS; ?>js/panier.js"></script>
</body>

</html>