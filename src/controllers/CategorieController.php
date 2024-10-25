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

    public function getAllProductsBycategorie($categorieId)
    {
        return $this->modelCategorie->getAllProductsBycategorie($categorieId);
    }

}
