<?php

namespace Model;
class User extends \Model\Model
{
    private int $id;
    private string $name;
    private string $email;
    private string $password;
    private string $avatar;

    public function getByEmail(string $email): self|null
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $user=$stmt->fetch();

        if (!$user){
            return null;
        }

        $obj = new self();
        $obj->id = $user['id'];
        $obj->name = $user['name'];
        $obj->email = $user['email'];
        $obj->password = $user['password'];
        if (isset($user['avatar'])){
            $obj->avatar = $user['avatar'];
        }

        return $obj;
    }

    public function insert(string $name, string $email, $password)
    {
        $stmt = $this->pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password]);
    }

    public function getBySessionId($sessionId): self|null
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = :sessionId");
        $stmt->execute(['sessionId' => $sessionId]);
        $user = $stmt->fetch();

        if (!$user){
            return null;
        }

        $obj = new self();
        $obj->id = $user['id'];
        $obj->name = $user['name'];
        $obj->email = $user['email'];
        $obj->password = $user['password'];

        return $obj;
    }

    public function getById($userId): self|null
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = :userId");
        $stmt->execute([':userId' => $userId]);
        $user = $stmt->fetch();

        if (!$user){
            return null;
        }

        $obj = new self();
        $obj->id = $user['id'];
        $obj->name = $user['name'];
        $obj->email = $user['email'];
        $obj->password = $user['password'];
        if (isset($user['avatar'])){
            $obj->avatar = $user['avatar'];
        }

        return $obj;
    }

    public function getAvatarById($userId): self|null
    {
        $stmt = $this->pdo->prepare("SELECT avatar FROM users WHERE id = :id");
        $stmt->execute([':id' => $_SESSION['userId']]);
        $user = $stmt->fetch();
        if (!$user){
            return null;
        }
        $obj = new self();
        if (isset($user['avatar'])){
            $obj->avatar = $user['avatar'];
        }
        return $obj;
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


    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getAvatar(): ?string
    {
        if (isset($this->avatar)){
            return $this->avatar;
        } else {
            return null;
        }
    }


}