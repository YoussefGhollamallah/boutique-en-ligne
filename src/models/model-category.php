<?php
require_once('db.php');

class CategoryModel
{
    private $connexion;

    public function __construct()
    {
        $this->connexion = connexionBDD();
        $this->connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function AddCat($nom, $description) {
        $stmt = $this->connexion->prepare('INSERT INTO SousCategorie (id_sousCategorie, nom_sc, description_sc) VALUES (null, ?, ?)');
        $stmt->execute([$nom, $description]);
    }

    public function Search($description) {
        $stmt = $this->connexion->prepare('SELECT * FROM SousCategorie WHERE description_sc = ?'); // Ensure column name matches
        $stmt->execute([$description]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
