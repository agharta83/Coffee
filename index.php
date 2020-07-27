<?php

// Grâce au fichier .htaccess, toutes les requêtes HTTP
// sont redirigées (transparent) vers index.php
// => FrontController = point d'entrée unique

// Inclusion dela classe Database
require(__DIR__.'/inc/Database.php');
// Inclusion du Model Product
require(__DIR__.'/models/Product.php');
// Inclusion de MainController
require(__DIR__.'/controllers/MainController.php');

// Je récupère l'URL rewritée courante
if (isset($_GET['_url'])) {
    $currentURL = $_GET['_url'];
}
else {
    // Si aucune redirection car fichier existant
    $currentURL = '/';
}

// Définition des routes
// 1 route permet de définir la méthode de controller
// à utiliser pour une URL donnée

// Si la page demandée est la page store
if ($currentURL == '/store') {
    // Je crée une instance du controller
    $controller = new MainController();
    // Appel de la méthode correspondante
    $controller->store();
}
// Si la page demandée est la page store
else if ($currentURL == '/about') {
    // Je crée une instance du controller
    $controller = new MainController();
    // Appel de la méthode correspondante
    $controller->about();
}
// Si la page demandée est la page store
else if ($currentURL == '/products') {
    // Je crée une instance du controller
    $controller = new MainController();
    // Appel de la méthode correspondante
    $controller->products();
}
// Sinon, on affiche la page d'accueil
else {
    // Je crée une instance du controller
    $controller = new MainController();
    // Appel de la méthode correspondante
    $controller->home();
}
