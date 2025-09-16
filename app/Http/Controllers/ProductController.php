<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use App\Models\UserProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController
{
    public function getCatalog()
    {
            $products = Product::all();
            return view('catalog', ['products' => $products]);
    }

    public function getProductPage(int $id)
    {
        $product = Product::query()->find($id);
        $reviews = Review::query()->where('product_id', $id)->get();
//        print_r($product);exit;
        $averageRating = $reviews->avg('rating');
        return view('productPage',
                        [
                            'product' => $product,
                            'reviews' => $reviews,
                            'averageRating' => $averageRating
                        ]);
    }




}
