<?php

namespace Request;

class AddProductRequest
{
    public function __construct(private array $post)
    {
    }

    public function getProductId():int
    {
        return $this->post['product_id'];
    }

    public function getAmount():int
    {
        return $this->post['amount'];
    }


}