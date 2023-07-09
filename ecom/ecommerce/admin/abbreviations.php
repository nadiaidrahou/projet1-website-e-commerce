<?php
    include "connect.php";


    $templates = 'includes/templates/'; //L'emplacement du dossier templates
    $fonctions = 'includes/fonctions/'; //L'emplacement du dossier fonctions
    $biblitheque = 'includes/biblitheque/'; //L'emplacement du dossier bibliotheque
    $css = 'layout/css/'; //L'emplacement du dossier css
    $js = 'layout/js/'; //L'emplacement du dossier js
    $img = 'layout/img/'; //L'emplacement du dossier img

    //inclure des fichiers
    include $fonctions.'fonction.php';//pour les titres

    include $templates.'header.php';

    //inclure le nav bar dans toutes les pages sauf dans une page
    if(!isset($noNavbar)){ include $templates.'navbar.php';}
    




?>