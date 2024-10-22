<?php
include_once 'config/config.php';

// Autoloader pour charger les classes
myAutoload::start();

// Récupération de la route (paramètre 'r' dans l'URL)
$request = $_GET['r'] ?? 'index';  // index.php?r...

// Objet Routeur
$routeur = new Routeur($request);
$routeur->renderController();

