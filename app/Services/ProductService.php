<?php

namespace App\Services;

use App\Http\Requests\CreateReviewRequest;
use App\Http\Requests\EditProductRequest;
use App\Models\Product;
use App\Models\Review;
use App\Services\DTO\CreateProductDTO;
use App\Services\DTO\CreateReviewDTO;
use App\Services\DTO\EditProductDTO;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ProductService
{
    /**
     * Выдает все продукты из кэша
     *
     * @return Product
     */
    public function catalog()
    {
        return Cache::remember('products_all', 3600, function () {
            return Product::all();
        });
    }

    /**
     * Изменяет данные товара
     *
     * @param EditProductDTO $dto
     * @param Product $product
     * @return void
     */
    public function handleEditProductForm(EditProductDTO $dto, Product $product)
    {
        $updateData=[];

        if ($dto->getName() !== null && $dto->getName() !== '') {
            $updateData['name'] = $dto->getName();
        }

        if ($dto->getDescription() !== null && $dto->getDescription() !== '') {
            $updateData['description'] = $dto->getDescription();
        }

        if ($dto->getPrice() !== null) {
            $updateData['price'] = $dto->getPrice();
        }

        if ($dto->getImage() !== null && $dto->getImage() !== '') {
            $updateData['image'] = $dto->getImage();
        }

        if (!empty($updateData)) {
            Product::query()->where('id', $product->id)->update($updateData);
            Cache::forget('products_all');
        }
    }

    /**Создаёт новый товар
     *
     * @param CreateProductDTO $dto
     * @return void
     */
    public function createProduct(CreateProductDTO $dto)
    {
        Product::query()->create([
            'name' => $dto->getName(),
            'price' => $dto->getPrice(),
            'description' => $dto->getDescription(),
            'image' => $dto->getImage(),
        ]);
        Cache::forget('products_all');
    }

    /**
     * Удаляет товар
     *
     * @param Product $product
     * @return void
     */
    public function deleteProduct(Product $product)
    {
        $product->delete();
        Cache::forget('products_all');
    }


    /**
     * Создает отзыв товара
     *
     * @param CreateReviewRequest $request
     * @return void
     */
    public function createReview(CreateReviewDTO $dto)
    {
        $userId=Auth::id();
        Review::query()->create([
            'name' => $dto->getName(),
            'comment' => $dto->getComment(),
            'rating' => $dto->getRating(),
            'product_id' => $dto->getProductId(),
            'user_id' => $userId
        ]);
    }

}
