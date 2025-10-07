<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\EditProductRequest;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use App\Models\UserProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

class ProductController
{
    public function getCatalog()
    {
        $products = Cache::remember('products_all', 3600, function () {
            return Product::all();
        });

        return view('catalog', compact('products'));
    }

    public function getProductPage(int $id)
    {
        $product = Product::query()->find($id);
        $reviews = Review::query()->where('product_id', $id)->get();
        $averageRating = $reviews->avg('rating');
        return view('productPage',
                        [
                            'product' => $product,
                            'reviews' => $reviews,
                            'averageRating' => $averageRating
                        ]);
    }

    public function getEditProducts()
    {
        $products = Product::all();
        return view('editProducts', ['products' => $products]);
    }

    public function getEditProductForm(Product $product)
    {
        return view('editProductForm', ['product' => $product]);
    }

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
        return redirect()->route('editProducts')->with('success', 'Сохранения изменены и кэш сброшен!');

    }

    public function getCreateProductForm()
    {
        return view('createProductForm');
    }

    public function create(CreateProductRequest $request)
    {
        $data = $request->validated();

        Product::query()->create([
            'name' => $data['name'],
            'price' => $data['price'],
            'description' => $data['description'],
            'image' => $data['image'],
        ]);
        Cache::forget('products_all');

        return redirect()->route('editProducts')->with('success', 'Новый продукт успешно создан и кэш сброшен!');
    }

    public function delete(Product $product)
    {
        $product->delete();
        Cache::forget('products_all');

        return redirect()->route('editProducts')
            ->with('success', 'Продукт удалён и кэш сброшен');
    }



}
