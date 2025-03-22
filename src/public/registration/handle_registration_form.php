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

    if (isset($post['email'])) {
        $email = $post['email'];

        if (strlen($email)<2) {
            $errors['email'] = "email должен содержать больше 2 символов";
        } elseif (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $errors['email'] = "email некорректный";
        } else {
            $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
            $stmt->execute([':email' => $email]);
            $data = $stmt->fetchColumn();

            if ($data > 0) {
                $errors['email'] = 'Пользователь с таким email уже зарегистрирован';
            }
        }
    } else {
        $errors['email'] = 'email должен быть заполнен';
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

$errors = validation($_POST);

if (empty(validation($_POST))) {
    $name=$_POST['name'];
    $email=$_POST['email'];
    $password=$_POST['psw'];

    $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');

    $password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $pdo-> prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
    $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password]);

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email ");
    $stmt->execute(['email' => $email]);
    $data = $stmt->fetch();
//    echo "<pre>";
//    print_r($data);
    echo "\n Пользователь зарегистирован";
}

require_once './registration_form.php';
?>



