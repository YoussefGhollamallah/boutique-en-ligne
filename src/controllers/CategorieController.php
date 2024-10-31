<?php
// Path: src/controllers/CategorieController.php

class CategorieController
{
    private $modelCategorie;

    public function __construct()
    {
        $this->modelCategorie = new ModelCategorie();
    }

    public function getAllCategorie()
    {
        return $this->modelCategorie->getAllCategorie();
    }

    public function getAllSousCategories()
    {
        return $this->modelCategorie->getAllSousCategories();
    }

    public function getAllProductsBycategorie($categorieId)
    {
        return $this->modelCategorie->getAllProductsBycategorie($categorieId);
    }

    public function getSousCategoriesByCategory($categorieId)
    {
        return $this->modelCategorie->getSousCategoriesByCategory($categorieId);
    }
}
