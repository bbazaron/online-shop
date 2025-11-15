<?php

namespace App\Services;

use App\Models\UserProduct;
use App\Services\DTO\AddProductDTO;
use App\Services\DTO\DecreaseProductDTO;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Сервис отвечающий за бизнес логику внутри корзины
 */
class CartService
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
     * Возвращает продукты c их количеством и суммой одного конкретного продукта
     */
    public function getUserProductsWithSum()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $userProducts = $user->products()->get();

        $data = UserProduct::query()->where('user_id',Auth::id())->get();
        $newData = $data->map(function ($item) {
            return [
                'product_id' => $item->product_id,
                'amount' => $item->amount,
            ];
        });

        $dataByProductId = collect($data)->keyBy('product_id');

        $userProducts = $userProducts->map(function ($product) use ($dataByProductId) {
            $productId = $product->id;
            $product->amount = $dataByProductId[$productId]['amount'] ?? null;
            $product->sum = $product->amount*$product->price;
            return $product;
        });
        return $userProducts;
    }

    /**
     * @return mixed
     * Возвращает сумму всей корзины
     */
    public function getTotalSum():int
    {
        $userProducts = $this->getUserProductsWithSum();
        $totalSum = $userProducts->sum('sum');
        return $totalSum;
    }

    /**
     * Добавляет в корзину продукт по 1шт
     *
     * @param AddProductDTO $dto
     * @return void
     */
    public function addProductToCart(AddProductDTO $dto)
    {
        $userId=Auth::id();
        $productId = $dto->getProductId();

        $userProduct = UserProduct::query()->where('user_id',$userId)
            ->where('product_id',$productId)->first();

        if ($userProduct) {
            $userProduct->increment('amount');
        } else {
            UserProduct::query()->create([
                'product_id' => $productId,
                'user_id' => $userId,
                'amount'=>1
            ]);
        }
    }

    /**
     * Убавляет продукт из корзины по 1шт
     *
     * @param DecreaseProductDTO $dto
     * @return void
     */
    public function decreaseProductFromCart(DecreaseProductDTO $dto)
    {
        $userId=Auth::id();
        $productId = $dto->getProductId();

        $userProduct = UserProduct::query()->where('user_id',$userId)->where('product_id',$productId)->first();
        $amount = $userProduct->amount;
        if ($amount===1) {
            UserProduct::query()->where('product_id',$productId)->where('user_id',$userId)->delete();
        } elseif ($amount > 1) {
            $userProduct->decrement('amount');
        }
    }

}
