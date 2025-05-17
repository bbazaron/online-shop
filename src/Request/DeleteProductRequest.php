<?php

namespace Request;

class DeleteProductRequest
{
    public function __construct(private array $post)
    {
    }

    public function getProductId():int
    {
        return $this->post['product_id'];
    }
}