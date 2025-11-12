<?php

namespace App\Services;

use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\CreateReviewRequest;
use App\Http\Requests\EditProductRequest;
use App\Models\Product;
use App\Models\Review;
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
     * @param EditProductRequest $request
     * @param Product $product
     * @return void
     */
    public function handleEditProductForm(EditProductRequest $request, Product $product)
    {
        $data = $request->validated();
        $updateData=[];

        if (!empty($data['name'])) {
            $updateData['name'] = $data['name'];
        }

        if (!empty($data['description'])) {
            $updateData['description'] = $data['description'];
        }

        if (!empty($data['price'])) {
            $updateData['price'] = $data['price'];
        }

        if (!empty($data['image'])) {
            $updateData['image'] = $data['image'];
        }

        Product::query()->where('id', $product->id)->update($updateData);
        Cache::forget('products_all');
    }


    /**
     * Создает новый товар
     *
     * @param CreateProductRequest $request
     * @return void
     */
    public function createProduct(CreateProductRequest $request)
    {
        $data = $request->validated();
        Product::query()->create([
            'name' => $data['name'],
            'price' => $data['price'],
            'description' => $data['description'],
            'image' => $data['image'],
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
    public function createReview(CreateReviewRequest $request)
    {
        $userId=Auth::id();
        Review::query()->create([
            'name' => $request->get('name'),
            'comment' => $request->get('comment'),
            'rating' => $request->get('rating'),
            'product_id' => $request->get('product_id'),
            'user_id' => $userId
        ]);
    }

}
