<?php

function connexionBDD() {
    $host = '193.203.168.103';
    $dbname = 'u126908064_pixel_plush';
    $user  = 'u126908064_pixel_plush';
    $pass = 'Plateformeur_13';

    try {
        $bdd = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $bdd;
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
}