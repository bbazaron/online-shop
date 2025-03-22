<?php
session_start();
if (!isset($_SESSION['userId'])) {
    header("Location: /login");
}
$user_id=$_SESSION['userId'];

$pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');
$stmt = $pdo->prepare("SELECT COUNT(*) FROM user_products WHERE user_id = :userId");
$stmt->execute(['userId' => $user_id]);
$data = $stmt->fetch();
if ($data['count'] > 0) { // проверка количества заказов у пользователя

    $stmt = $pdo->prepare("SELECT * FROM user_products WHERE user_id = :userId ");
    $stmt->execute(['userId' => $user_id]);
    $data = $stmt->fetchAll(); // достаем все продукты у пользователя

foreach ($data as $product) {  // достаем описание каждого продукта из бд products

    $oprst = $pdo->prepare("SELECT name,description,price,image_url FROM products WHERE id = :id ");
    $oprst->execute(['id' => $product['product_id']]);
    $data1 = $oprst->fetch();
   //print_r($data1);
    $final = array_merge($product, $data1);
    $list[] = array_merge($final, $data1);;

    }
} else {
    $message = 'Корзина пуста';}

require_once './cart_page.php';



