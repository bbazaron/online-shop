<?php
session_start();
if (!isset($_SESSION['userId'])) {
    header("Location: /login");
}

function validation($post):array
{
    $errors = [];

    if (isset($post['product_id'])) {
        $product_id = $post['product_id'];
        if (is_numeric($product_id)===false) {
            $errors['product_id'] = "Введены неверные данные";
        } else {
            $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE id = :id");
            $stmt->execute([':id' => $product_id]);
            $data = $stmt->fetchColumn();
            if ($data === '0') {
                $errors['product_id'] = 'Введеного product_id не существует';}

            }
    }

    if (isset($post['amount'])) {
        $amount = $post['amount'];
        if (is_numeric($amount)===false) {
            $errors['amount'] = "Введены неверные данные";
        } else {
            if ($amount==='0') {
                $errors['amount'] = "amount не может быть 0";
            }
        }
    }
        return $errors;
}

$errors = validation($_POST);

if (empty($errors)) {
    $id = $_SESSION['userId'];
    $product_id = $_POST['product_id'];
    $amount = $_POST['amount'];

    $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');
    $check = $pdo->prepare("SELECT COUNT(*) FROM user_products WHERE user_id = :id");
    $check->execute(['id' => $id]);
    $data = $check->fetchColumn();

    if ($data > 0) {
        $stmt = $pdo-> prepare("UPDATE user_products SET amount = amount + :amount WHERE product_id = '$product_id'");
        $stmt->execute(  ['amount' => $amount]);
        $message = "Продукты добавлены повторно";
    } else {
        $stmt = $pdo-> prepare("INSERT INTO user_products (user_id, product_id, amount) VALUES (:user_id, :product_id, :amount)");
        $stmt->execute(['user_id' => $id, 'product_id' => $product_id, 'amount' => $amount]);
        $message = "Продукты добавлены ";
    }




}
require_once './add_product_form.php';