<?php

namespace App\Http\Controllers;

use App\Http\Services\CartService;
use App\Models\UserProduct;
use http\Client\Curl\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController
{
    protected $cartService;
    public function __construct()
    {
        $this->cartService = new cartService();
    }
    public function getCart()
    {

        $userProducts = $this->cartService->getUserProductsWithSum();
        $totalSum = $this->cartService->getTotalSum();
        return view('cart', ['userProducts' => $userProducts, 'totalSum' => $totalSum]);


//        $userProducts = UserProduct::with('product')
//            ->where('user_id', Auth::id())
//            ->get();
//
//        $collection = $userProducts->map(function ($item) {
//            return [
//                'id' => $item->product->id,
//                'name' => $item->product->name,
//                'description' => $item->product->description,
//                'price' => $item->product->price,
//                'image' => $item->product->image,
//            ];
//        });

//        $userProducts = UserProduct::with('product')
//            ->where('user_id', Auth::id())
//            ->get();
//        echo"<pre>";print_r($userProducts);exit;

//        foreach ($collection as $product) {
//            $arr[]=$product;
//        }
//
    }

    public function addProductToCart(Request $request)
    {
        $userId=Auth::id();
        $productId = $request->get('product_id');

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


    public function decreaseProductFromCart(Request $request)
    {
        $userId=Auth::id();
        $productId = $request->get('product_id');

        $userProduct = UserProduct::query()->where('user_id',$userId)->where('product_id',$productId)->first();
        $amount = $userProduct->amount;
        if ($amount===1) {
            UserProduct::query()->where('product_id',$productId)->where('user_id',$userId)->delete();
        } elseif ($amount > 1) {
            $userProduct->decrement('amount');
        }
    }
}
