<?php

function validation (array $post){
    $errors=[];

    if (!isset($post['username'])) {
        $errors['username']="Username is required!";
    }

    if (!isset($post['password'])) {
        $errors['password']="Password is required!";
    }

    return $errors;
}

$errors=validation($_POST);

if (empty($errors)) {
    $username = $_POST['username'];
    $password = $_POST["password"];

    $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email= :email");
    $stmt->execute(['email' => $username]);

    $user = $stmt->fetch();


    if ($user === false) {
        $errors['username'] = 'username or password not valid';
    } else {
        $passwordDb = $user['password'];

        if (password_verify($password, $passwordDb)) {
            if (session_status() !== PHP_SESSION_ACTIVE) {
                session_start();
            }

            $_SESSION['userId'] = $user['id'];
            header("Location: /catalog");
            exit;
        } else {
            $errors['username'] = 'username or password not valid';
        }
    }
}

require_once './login/login_form.php';