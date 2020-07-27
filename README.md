# MVC

Voici un petit site internet de 4 pages.

Actuellement, il est composé de 4 fichiers HTML statiques.

On va améliorer ce site et rendre le tout dynamique, tout en suivant l'architecture MVC.

## Etape 1 : préparation

- déplacer les fichiers HTML dans un sous-répertoire _views_
- renommer ces fichiers HTML en fichiers PHP
- créer les 4 fichiers "point d'entrée" PHP à la racine du projet :
  - index.php
  - products.php
  - store.php
  - about.php
- dans chacun de ces fichiers, inclure le fichier de vue correspondant
  ```php
  include(__DIR__.'/views/index.php'); // pour la home
  ```

## Etape 2 : views

- factoriser le code HTML répété dans les fichiers de vues
  - créer une vue `header.php` dans _views_
  - créer une vue `footer.php` dans _views_
- modifier les fichiers "point d'entrée" pour inclure ces vues `header.php` et `footer.php`

## Etape 3 : controllers

- créer une classe `MainController` dans le sous-répertoire `controllers`
- déclarer 4 méthodes vides dans ce `MainController` :
  - `home` (correspondant à la page `index.php`)
  - `about` (correspondant à la page `about.php`)
  - `products` (correspondant à la page `products.php`)
  - `store` (correspondant à la page `store.php`)
- déclarer la méthode `show` dans `MainController` qui va s'occuper d'inclure les _views_
  ```php
  public function show($viewName, $viewVars=array()) {
    // $viewVars est disponible dans chaque fichier de vue
    include(__DIR__.'/../views/header.php');
    include(__DIR__.'/../views/'.$viewName.'.php');
    include(__DIR__.'/../views/footer.php');
  }
  ```
- dans le corps des 4 méthodes vides, appeler la méthode `show` sur l'objet courant (`$this`) en précisant en paramètre quelle _views_ vous souhaitez
  ```php
  public function home() {
    // Délègue l'affichage à la méthode "show" du MainController
    $this->show('home');
  }
  ```
- modifier chaque fichier "point d'entrée"
  - retirer l'inclusion existante (_views_)
  - inclure la classe `MainController`
  - instancier un objet `MainController`
  - appeler la méthode de l'objet `MainController` correspondant au point d'entrée
    ```php
    <?php
    // File index.php
    // Instanciation de la classe MainController
    $controller = new MainController();
    // Appel de la méthode correspondant à ce point d'entrée (page)
    $controller->home();
    ```
- `point d'entrée` > `méthode du controller` > `views` > "Job's done" :muscle:

## Etape 4 : models

- créer un user `coffee` et une base de donnée avec le même nom
- importer le fichier [coffee.sql](data/coffee.sql)
- page `products.php` => produits à récupérer depuis la base de données
  - créer une classe `Product` dans le sous-répertoire `models`
  - déclarer les propriétés publiques suivantes (les mêmes que les champs de la table) :
    - id
    - title
    - subtitle
    - image
    - text
  - déclarer les 4 méthodes vides suivantes (CRUD) dans `Product` :
    - `create`
    - `read`
    - `update`
    - `delete`
  - déclarer la méthode `getAll` dans `Product` permettant de renvoyer la liste complète des _Products_ en base de données
    ```php
    public function getAll() {
      $sql = '
        SELECT *
        FROM products
      ';
      // Database::getPDO() est une méthode statique de la classe Database fournie dans "inc/Database.php"
      $pdoStatement = Database::getPDO()->query($sql);
      // Définie la classe que je veux comme résultat
      $pdoStatement->setFetchMode(PDO::FETCH_CLASS, 'Product');
      // Retourne tous les résultats sous forme d'array d'objets Product
      return $pdoStatement->fetchAll(PDO::FETCH_CLASS);
    }
    ```
  - `PDO::FETCH_CLASS` est nouveau, on avait vu `PDO::FETCH_OBJ` qui génère des objets _anonymes_. Avec `PDO::FETCH_CLASS`, PDO génère automatiquement des objets pour une classe précise
  - dans le corps de la méthode `products` du `MainController` :
    - instancier le model (la classe) `Product`
    - appeler la méthode `getAll()`
    - récupérer le retour de la méthode dans la variable `$productsList`
    - transmettre cette variable aux _views_ => 2e paramètre (type=array) de la méthode `show`
      ```php
      $this->show('products', [
        'productsList' => $productsList
      ]);
      ```
    - dans la _views_ `views/products.php` :
      - repérer la `<section>` répétée pour chaque produit
      - remplacer les `<section>` en dur par du PHP dynamqiue (boucle foreach sur `$viewVars['productsList']`)

`point d'entrée`  
:arrow_down:  
`méthode de controller` :arrow_left: :arrow_right: `méthode(s) de model(s)`  
:arrow_down:  
`views`

## Dernière étape

Job's done ! :muscle: :tada: :champagne:

Se féliciter, relire la structure de nos fichiers et se représenter le parcours du script PHP dans nos fichiers pour afficher une page HTML
