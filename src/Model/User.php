<?php
class User
{
    public function getByEmail(string $email):array|false
    {
        require_once '../Model/PDO.php';
        $pdo = new MyPdo();

        $stmt = $pdo->getPDO()->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute([':email' => $email]);

        $result=$stmt->fetch();

        return $result;
    }

    public function insert(string $name, string $email, $password)
    {
        require_once '../Model/PDO.php';
        $pdo = new MyPdo();

        $stmt = $pdo->getPDO()->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password]);
    }

    public function getBySessionId($sessionId):array|false
    {
        require_once '../Model/PDO.php';
        $pdo = new MyPdo();

        $stmt = $pdo->getPDO()->query('SELECT * FROM users WHERE id = ' . $sessionId);
        $user = $stmt->fetch();
        return $user;
    }

    public function getById($userId):array|false
    {
        require_once '../Model/PDO.php';
        $pdo = new MyPdo();

        $stmt = $pdo->getPDO()->query("SELECT * FROM users WHERE id = $userId");
        $user = $stmt->fetch();
        return $user;
    }

    public function getAvatarById($userId):string|false|null
    {
        require_once '../Model/PDO.php';
        $pdo = new MyPdo();

        $stmt = $pdo->getPDO()->prepare("SELECT avatar FROM users WHERE id = :id");
        $stmt->execute([':id' => $_SESSION['userId']]);
        $avatar = $stmt->fetchColumn();
        return $avatar;
    }

    public function updateNameById(string $name, $userId )
    {
        require_once '../Model/PDO.php';
        $pdo = new MyPdo();

        $stmt = $pdo->getPDO()->prepare("UPDATE users SET name = :name WHERE id= $userId");
        $stmt->execute([':name' => $name]);
    }

    public function updateEmailById(string $email, $userId)
    {
        require_once '../Model/PDO.php';
        $pdo = new MyPdo();

        $stmt = $pdo->getPDO()->prepare("UPDATE users SET email = :email WHERE id= $userId");
        $stmt->execute([':email' => $email]);
    }

    public function updatePasswordById($password, $userId)
    {
        require_once '../Model/PDO.php';
        $pdo = new MyPdo();

        $stmt = $pdo->getPDO()->prepare("UPDATE users SET password = :password WHERE id= $userId");
        $stmt->execute([':password' => $password]);
    }

    public function updateAvatarById($avatar, $userId)
    {
        require_once '../Model/PDO.php';
        $pdo = new MyPdo();

        $stmt = $pdo->getPDO()->prepare("UPDATE users SET avatar = :image_url WHERE id= $userId");
        $stmt->execute([':image_url' => $avatar]);
    }
}