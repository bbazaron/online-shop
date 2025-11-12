<?php

namespace App\Services\Clients\DTO;

class YouGileClientCreateTaskDTO
{
    public function __construct(
        private string $description,
        private int $orderId,

    ){}

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getOrderId(): int
    {
        return $this->orderId;
    }


}
