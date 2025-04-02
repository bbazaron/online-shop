<?php

namespace Model;
class User extends \Model\Model
{
    public function getByEmail(string $email):array|false
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute([':email' => $email]);

        $result=$stmt->fetch();

        return $result;
    }

    public function insert(string $name, string $email, $password)
    {
        $stmt = $this->pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password]);
    }

    public function getBySessionId($sessionId):array|false
    {
        $stmt = $this->pdo->query('SELECT * FROM users WHERE id = ' . $sessionId);
        $user = $stmt->fetch();
        return $user;
    }

    public function getById($userId):array|false
    {
        $stmt = $this->pdo->query("SELECT * FROM users WHERE id = $userId");
        $user = $stmt->fetch();
        return $user;
    }

    public function getAvatarById($userId):string|false|null
    {
        $stmt = $this->pdo->prepare("SELECT avatar FROM users WHERE id = :id");
        $stmt->execute([':id' => $_SESSION['userId']]);
        $avatar = $stmt->fetchColumn();
        return $avatar;
    }

    public function updateNameById(string $name, $userId )
    {
        $stmt = $this->pdo->prepare("UPDATE users SET name = :name WHERE id= $userId");
        $stmt->execute([':name' => $name]);
    }

    public function updateEmailById(string $email, $userId)
    {
        $stmt = $this->pdo->prepare("UPDATE users SET email = :email WHERE id= $userId");
        $stmt->execute([':email' => $email]);
    }

    public function updatePasswordById($password, $userId)
    {
        $stmt = $this->pdo->prepare("UPDATE users SET password = :password WHERE id= $userId");
        $stmt->execute([':password' => $password]);
    }

    public function updateAvatarById($avatar, $userId)
    {
        $stmt = $this->pdo->prepare("UPDATE users SET avatar = :image_url WHERE id= $userId");
        $stmt->execute([':image_url' => $avatar]);
    }
}