<?php

namespace Services;

use Model\Product;

class ProductService
{
    public function addNewProduct(\DTO\AddNewProductDTO $dto)
    {
        Product::insert($dto->getName(),$dto->getPrice(),$dto->getImageUrl(),$dto->getDescription());
    }

    public function deleteProduct(\DTO\DeleteProductDTO $dto)
    {
        Product::deleteById($dto->getProductId());
    }


}