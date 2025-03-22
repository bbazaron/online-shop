<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (!isset($_SESSION['userId'])) {
    header("Location: /login");
    exit;
} else {
    $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');

    $stmt = $pdo->query('SELECT * FROM users WHERE id = ' . $_SESSION['userId']);
    $user = $stmt->fetch();
    echo "<pre>";
//print_r($data);
    require_once './profile/profile_page.php';
}
