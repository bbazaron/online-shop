<?php

namespace Model;
class User extends \Model\Model
{
    private int $id;
    private string $name;
    private string $email;
    private string $password;
    private string $avatar;

    protected static function getTableName(): string
    {
        return 'users';
    }

    public static function getByEmail(string $email): self|null
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("SELECT * FROM $tableName WHERE email = :email");
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

    public static function insert(string $name, string $email, $password)
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("INSERT INTO $tableName (name, email, password) VALUES (:name, :email, :password)");
        $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password]);
    }

    public static function getBySessionId($sessionId): self|null
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("SELECT * FROM $tableName WHERE id = :sessionId");
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

    public static function getById($userId): self|null
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("SELECT * FROM $tableName WHERE id = :userId");
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

    public static function getAvatarById(): self|null
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("SELECT avatar FROM $tableName WHERE id = :id");
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

    public static function updateNameById(string $name, $userId )
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("UPDATE $tableName SET name = :name WHERE id= $userId");
        $stmt->execute([':name' => $name]);
    }

    public static function updateEmailById(string $email, $userId)
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("UPDATE $tableName SET email = :email WHERE id= $userId");
        $stmt->execute([':email' => $email]);
    }

    public static function updatePasswordById($password, $userId)
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("UPDATE $tableName SET password = :password WHERE id= $userId");
        $stmt->execute([':password' => $password]);
    }

    public static function updateAvatarById($avatar, $userId)
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("UPDATE $tableName SET avatar = :image_url WHERE id= :userId");
        $stmt->execute([':image_url' => $avatar, ':userId' => $userId]);
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