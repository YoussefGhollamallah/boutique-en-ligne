<?php

class CategoryModel
{
    private $connexion;

    public function __construct()
    {
        $conn = new Connexion();
        $this->connexion = $conn->connexionBDD();
        $this->connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function AddCat($nom, $description) {
        $stmt = $this->connexion->prepare('INSERT INTO SousCategorie (id_sousCategorie, nom_sc, description_sc) VALUES (null, ?, ?)');
        $stmt->execute([$nom, $description]);
    }

    public function ModifyCat($nom, $description, $id) {
        $stmt = $this->connexion->prepare('UPDATE SousCategorie SET nom_sc = ?, description_sc = ? WHERE id_sousCategorie = ?');
        $stmt->execute([$nom, $description, $id]);
    }

    public function getCategories() {
        $stmt = $this->connexion->query('SELECT * FROM SousCategorie');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function Delete($id) {
        $stmt = $this->connexion->prepare('DELETE FROM SousCategorie WHERE id_sousCategorie = ?');
        $stmt->execute([$id]);
    }
}
?>