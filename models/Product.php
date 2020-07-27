<?php

// Un model pour la table products
// 1 model pour 1 table (DB)
class Product {
    // 1 propriété pour chaque champ de la table
    public $id;
    public $title;
    public $subtitle;
    public $image;
    public $text;
    // On peut ajouter des propriétés que ne sont pas des champs de la table
    
    // Méthode réprésentant le CRUD sur l'objet/la ligne de la table
    public function create() {
        
    }
    
    public function read() {
        
    }
    
    public function update() {
        
    }
    
    public function delete() {
        
    }
    
    // Méthode permettant de renvoyer tous les produits en DB
    // sous forme d'objets Product
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
}
