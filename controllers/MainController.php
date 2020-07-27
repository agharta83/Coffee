<?php

// classe MainController
class MainController {
  
    // Méthode gérant la page Home
    public function home() {
        // Appel la méthode s'occupant de la partie views
        $this->show('index');
    }

    // Méthode gérant la page about
    public function about() {
        // Appel la méthode s'occupant de la partie views
        $this->show('about');
    }

    // Méthode gérant la page products
    public function products() {
        // Je récupère tous les produits de la DB
        $productModel = new Product();
        $productsList = $productModel->getAll();
        // Appel la méthode s'occupant de la partie views
        // + on passe la valeur de $productsList à la view
        $this->show('products', [
            'productsList' => $productsList
        ]);
    }

    // Méthode gérant la page store
    public function store() {
        // Appel la méthode s'occupant de la partie views
        $this->show('store');
    }
    
    // Méthode permettant de factoriser le code appelant les views
    private function show($viewName, $viewVars=array()) {
        // $viewVars est disponible dans chaque fichier de vue
        // Inclusion des views
        include(__DIR__.'/../views/header.php');
        include(__DIR__.'/../views/'.$viewName.'.php');
        include(__DIR__.'/../views/footer.php');
    }
  
}
