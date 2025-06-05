<?php

namespace App\Http\Services;

use App\Models\UserProduct;
use Illuminate\Support\Facades\Auth;

class CartService
{
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

    public function getTotalSum()
    {
        $userProducts = $this->getUserProductsWithSum();
        $totalSum = $userProducts->sum('sum');
        return $totalSum;
    }


}
