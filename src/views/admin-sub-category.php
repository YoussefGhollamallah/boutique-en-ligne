<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../assets/css/admin.css"> <!-- Link to the external CSS file -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion</title>
</head>
<body>
    <form class="Form" id="categoryForm" action="../controllers/AdminTreatments.php" method="post" enctype="multipart/form-data">
        <section class="container">
            <section class="section">
                <button id="modify" type="button">Modifier</button>
                <img class="logo" src="../../assets/images/logo.png" alt="">
                <label for="categories">Nom de Categories</label>
                <input type="text" id="categories" placeholder="Name" name="nom">
            </section>
            <section class="section">
                <textarea name="desc" id="desc" rows="4" placeholder="Description"></textarea>
            </section>
            <input type="submit" class="btn btn-ajouter" value="Valider">
        </section>
    </form>

    <!-- Hidden form -->
    <form class="HiddenForm" id="hiddenForm" action="../controllers/AdminTreatments.php" method="post" enctype="multipart/form-data" style="display: none;">
        <section class="container">
            <section class="section">
                <button id="Add" type="button">Ajouter</button>
                <img class="logo" src="../../assets/images/logo.png" alt="">
                <label for="newName">Modifier le Nom</label>
                <input type="text" id="newName" placeholder="Name" name="newName">
            </section>
            <section class="section">
                <textarea name="descHidden" id="descHidden" rows="4" placeholder="Description"></textarea>
            </section>
            <input type="submit" class="btn-Modifier" value="Modifier">
            <label for="cible">Cible</label>
            <select id="cible" name="cible" multiple size="5"></select>
            <input type="submit" class="btn-Supprimer" value="Supprimer">
            <label for="sup">Supprimer</label>
            <select id="sup" name="sup" multiple size="5"></select>
        </section>
    </form>

    <script src="../../assets/js/admin.js"></script>
</body>
</html>
