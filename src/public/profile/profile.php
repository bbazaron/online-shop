<?php
session_start();
if (!isset($_SESSION['userId'])) {
    header("Location: /login");
}
$pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');

$stmt = $pdo -> query('SELECT * FROM users WHERE id = '.$_SESSION['userId']);
$data = $stmt->fetchAll();
echo "<pre>";
//print_r($data);
require_once './profile_page.php';

