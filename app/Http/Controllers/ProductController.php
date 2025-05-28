<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Models\UserProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController
{
    public function getCatalog()
    {
        if (Auth::check()) {
            $products = Product::all();
            return view('catalog', ['products' => $products]);
        } else {
            return response()->redirectTo('login');
        }
    }

    public function getProductPage(Request $request)
    {
        $product = Product::find($request->get('product_id'));
        $productData = $product->only(['id','name','description','price','image']);
        return view('productPage', ['product' => $productData]);
    }

    public function addProductToCart(Request $request)
    {
            $userId=Auth::id();
            $productId = $request->get('product_id');
            UserProduct::query()->create([
                'product_id' => $productId,
                'user_id' => $userId,
                'amount'=>1
            ]);
    }

    public function decreaseProductFromCart(Request $request)
    {

    }
}
