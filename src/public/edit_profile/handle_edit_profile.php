<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (!isset($_SESSION['userId'])) {
    header("Location: /login");
    exit;
}

function validation(array $post):array
{
    $errors = [];

    if (isset($post['name'])) {
        $name = $post['name'];

        if (strlen($name) < 2) {
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
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->execute([':email' => $email]);
            $data = $stmt->fetch();

            if ($data !== false){ // запрос вернет false если не найдет введеный email
                $userId = $_SESSION['userId'];
                if ($data['id'] !== $userId) {
                    $errors['email'] = 'Пользователь с таким email уже зарегистрирован';
                }
            }
        }
    }

    if (isset($post['psw'])) {
        if ($post['psw']!=="") {
            $password = $post['psw'];

            if (strlen($password) < 2) {
                $errors['password'] = "Пароль должен содержать больше 2 символов";
            } elseif (isset($post['psw-repeat'])) {

                $pswRepeat = $post['psw-repeat'];

                if ($password !== $pswRepeat) {
                    $errors['psw-repeat'] = "Пароли не совпадают";
                }
            } else {
                $errors['psw-repeat'] = "Повторите пароль";
            }
        }

    }
    return $errors;
}

$errors = validation($_POST);

if (empty($errors)) {
    $id = $_SESSION['userId'];
    $username = $_POST['name'];
    $email = $_POST['email'];
    $avatar = $_POST['avatar'];
    $image_url = $_POST['avatar'];

    if($_POST["psw"] !== ""){ //проверка пароля на пустоту
        $password = $_POST["psw"];
        $password = password_hash($password, PASSWORD_DEFAULT);
    } else {
        $password = "";
    }



    $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');

    $stmt = $pdo->query("SELECT * FROM users WHERE id = $id");
    $user = $stmt->fetch();

    if ($user['name'] !== $username) {
        $stmt = $pdo->prepare("UPDATE users SET name = :name WHERE id= $id");
        $stmt->execute([ ':name' => $username]);
    }

    if ($user['email'] !== $email) {
        $stmt = $pdo->prepare("UPDATE users SET email = :email WHERE id= $id");
        $stmt->execute([ ':email' => $email]);
    }

    if ($user['password'] !== $password && $password!=="") {
        $stmt = $pdo->prepare("UPDATE users SET password = :password WHERE id= $id");
        $stmt->execute([ ':password' => $password]);
    }

    if ($user['avatar'] !== $image_url && $image_url!=="") {
        $stmt = $pdo->prepare("UPDATE users SET avatar = :image_url WHERE id= $id");
        $stmt->execute([ ':image_url' => $image_url]);
    }
    //var_dump($_POST);
    header("Location: /profile");
    exit;

} else {
    require_once './edit_profile/edit_profile.php';
}



