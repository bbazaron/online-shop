<?php

function validation(array $post):array
{
    $errors = [];

    if (isset($post['name'])) {
        $name = $post['name'];

        if (strlen($name)<2) {
            $errors['name'] = "Имя должно содержать больше 2 символов";
        }
    } else {
        $errors['name'] = "Имя должно быть заполнено";
    }

    if (isset($post['psw'])) {
        $password = $post['psw'];

        if (strlen($password)<2) {
            $errors['password'] = "Пароль должен содержать больше 2 символов";
        } elseif (isset($post['psw-repeat'])) {

            $pswRepeat = $post['psw-repeat'];

            if ($password !== $pswRepeat) {
                $errors['psw-repeat'] = "Пароли не совпадают";
            }
        } else {$errors['psw-repeat'] = "Повторите пароль";}

    } else {
        $errors['password'] = "Пароль должен быть заполнен";
    }
    return $errors;
}

$errors=validation($_POST);

if (empty($errors)) {
    session_start();
    if (!isset($_SESSION['userId'])) {
        header("Location: /login.php");
    }
    $id =$_SESSION['userId'];
    $username = $_POST['name'];
    $avatar = $_POST['avatar'];
    $password = $_POST["psw"];
    $password = password_hash($password, PASSWORD_DEFAULT);

    $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');
    $stmt = $pdo->prepare("UPDATE users SET name = :username, password = :password, avatar = :avatar WHERE id= :id");
    $stmt->execute([':id' => $id, ':username' => $username, ':password' => $password, ':avatar' => $avatar]);

    $user = $stmt->fetch();

    header("Location: /profile");

} else {
    require_once './change_data/change_data.php';
}


