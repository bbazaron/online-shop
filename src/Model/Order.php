<?php

namespace Model;

class Order extends \Model\Model
{
    private int $id;
    private string $contactName;
    private string $contactPhone;
    private string|null $comment; // необязательное поле для заполнения в форме
    private string $address;

    private $orderProducts=[];
    private int|float $totalSum;

    public function create( string $contactName, string $contactNumber, string $address, string $comment,int $userId):int
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO orders ( contact_name, contact_phone, address, comment, user_id)
                    VALUES (:contactName, :contactNumber, :address, :comment, :userId)  RETURNING id"
        );

        $stmt->execute([
                        'contactName' => $contactName,
                        'contactNumber' => $contactNumber,
                        'address' => $address,
                        'comment' => $comment,
                        'userId'=>$userId
                    ]);

        $data = $stmt->fetch();
        return $data['id'];
    }


    public function getAllByUserId($userId):array|null
    {
        $stmt = $this->pdo->prepare("SELECT * FROM orders WHERE user_id = :userId");
        $stmt->execute(['userId'=>$userId]);
        $orders = $stmt->fetchAll();
        $arr=[];
        foreach ($orders as $order){
            if (!$order){
                return null;
            }
            $obj = new self();
            $obj->id = $order['id'];
            $obj->contactName = $order['contact_name'];
            $obj->contactPhone = $order['contact_phone'];
            $obj->address = $order['address'];
            if (isset ($order['comment'])){ //комментарий может быть пустым
                $obj->comment = $order['comment'];
            } else {
                $obj->comment = null;
            }

            array_push($arr, $obj); // объединение массивов $obj в конец $arr
        }

        return $arr;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getContactName(): string
    {
        return $this->contactName;
    }

    public function getContactPhone(): string
    {
        return $this->contactPhone;
    }

    public function getComment(): string|null
    {
        if ($this->comment === null){
            return null;
        } else {
            return $this->comment;
        }
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getOrderProducts(): array
    {
        return $this->orderProducts;
    }

    public function getTotalSum(): float|int
    {
        return $this->totalSum;
    }


    public function setOrderProducts(OrderProducts|array $orderProducts): void
    {
        if (!is_array($orderProducts)){
            $this->orderProducts = $orderProducts;
        } else {
            foreach ($orderProducts as $orderProduct){
                $this->orderProducts[] = $orderProduct;
            }
        }

    }

    public function setTotalSum(float|int $totalSum): void
    {
        $this->totalSum = $totalSum;
    }






}