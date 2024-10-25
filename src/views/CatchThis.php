<?php


include('../models/db.php');

include('../models/ModelCategory.php');

$categoryModel = new CategoryModel();
$categories = $categoryModel->getCategories();



?>