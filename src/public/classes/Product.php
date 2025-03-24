<?php

class Product
{
    public function getCatalog()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        if (!isset($_SESSION['userId'])) {
            header("Location: /login");
            exit;
        }
        require_once './catalog/catalog_page.php';

    }

    public function catalog()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        if (!isset($_SESSION['userId'])) {
            header("Location: /login");
            exit;
        }

        $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');

        $stmt = $pdo->query('SELECT * FROM products');
        $products = $stmt->fetchAll();

        require_once './catalog/catalog_page.php';
    }

    public function validateProduct($post): array
    {
        $errors = [];

        if (isset($post['product_id'])) {
            $product_id = (int) $post['product_id'];

            $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');
            $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :product_id");
            $stmt->execute([':product_id' => $product_id]);
            $data = $stmt->fetch();
            if ($data === false) {
                $errors['product_id'] = $data;
            }
        }


        if (isset($post['amount'])) {
            $amount = $post['amount'];
            if (is_numeric($amount) === false) {
                $errors['amount'] = "Введены неверные данные";
            } elseif($amount === '0') {
                $errors['amount'] = "amount не может быть 0";
            }
        }
        return $errors;
    }

    public function addToCart()
    {
        $errors = $this->validateProduct($_POST);
        print_r($errors);
        if (empty($errors)) {
            $userid = $_SESSION['userId'];
            $product_id = $_POST['product_id'];
            $amount = $_POST['amount'];

            $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');
            $check = $pdo->prepare("SELECT * FROM user_products WHERE product_id = :product_id AND user_id = :userId");
            $check->execute(['product_id'=> $product_id, 'userId' => $userid]);
            $data = $check->fetch();

            if ($data ===false) {
                $stmt = $pdo->prepare("INSERT INTO user_products (user_id, product_id, amount) VALUES (:user_id, :product_id, :amount)");
                $stmt->execute(['user_id' => $userid, 'product_id' => $product_id, 'amount' => $amount]);
                $message = "Продукты добавлены ";
                echo $message;
            } else {
                $amount = $data['amount'] + $amount;
                $stmt = $pdo->prepare("UPDATE user_products SET amount = :amount WHERE user_id = :user_id AND product_id = :product_id");
                $stmt->execute(['amount' => $amount, 'user_id' => $userid, 'product_id' => $product_id ]);
                $message = "Продукты добавлены повторно";
            }


        }
        $this->catalog();
    }
}