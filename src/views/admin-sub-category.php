<form id="categoryForm" action="../controllers/admin-treatments.php" method="post" enctype="multipart/form-data">
        <section class="container">
            <section class="section">
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
    <script src="<?php echo ASSETS ?>/js/admin.js"></script>

