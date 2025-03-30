<?php
class Product
{
    public function getAllProducts():array|false
    {
        require_once '../Model/PDO.php';
        $pdo = new MyPdo();

        $stmt = $pdo->getPDO()->query('SELECT * FROM products');
        $products = $stmt->fetchAll();
        return $products;
    }

    public function getById($product_id):array|false
    {
        require_once '../Model/PDO.php';
        $pdo = new MyPdo();

        $stmt = $pdo->getPDO()->prepare("SELECT * FROM products  WHERE id = :product_id");
        $stmt->execute([':product_id' => $product_id]);
        $data = $stmt->fetch();
        return $data;
    }

//    public function getById($product):array|false
//    {
//        $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');
//
//        $stmt = $pdo->prepare("SELECT name,description,price,image_url FROM products WHERE id = :id ");
//        $stmt->execute(['id' => $product['product_id']]);
//        $data = $stmt->fetch();
//        return $data;
//    }
}