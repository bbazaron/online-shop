<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\CreateReviewRequest;
use App\Http\Requests\EditProductRequest;
use App\Http\Services\ProductService;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use App\Models\UserProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
/**
 * Контроллер отвечает за продукты
 */
class ProductController
{
    private ProductService  $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     *  Выдает страницу каталога, достает из кэша
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|object
    */
    public function getCatalog()
    {
        $products = Cache::remember('products_all', 3600, function () {
            return Product::all();
        });

        return view('catalog', compact('products'));
    }

    /**
     * Выдает страницу товара с отзывами
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|object
     */
    public function getProductPage(int $id) // нужно ли выносить с вервис?
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

    /**
     * Создает отзыв товара
     *
     * @param CreateReviewRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createReview(CreateReviewRequest $request)
    {
        $this->productService->createReview($request);
        return redirect()->back()->with('Success', 'Спасибо за отзыв!');
    }

    /**
     * Выдает страницу редактирования товаров. Кнопка "Редактировать товары"
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|object
     */
    public function getEditProducts()
    {
        $products = Product::all();
        return view('editProducts', ['products' => $products]);
    }

    /**
     * Выдает форму редактирования товара
     *
     * @param Product $product
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|object
     */
    public function getEditProductForm(Product $product)
    {
        return view('editProductForm', ['product' => $product]);
    }


    /**
     * Изменяет данные товара, сброс кэша после изменений
     *
     * @param EditProductRequest $request
     * @param Product $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleEditProductForm(EditProductRequest $request, Product $product)
    {
        $this->productService->handleEditProductForm($request, $product);
        return redirect()->route('editProducts')->with('success', 'Сохранения изменены и кэш сброшен!');
    }

    /**
     * Выдача страницы создания товара
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|object
     */
    public function getCreateProductForm()
    {
        return view('createProductForm');
    }

    /**
     * Создание товара, сброс кэша после изменений
     *
     * @param CreateProductRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(CreateProductRequest $request)
    {
        $this->productService->createProduct($request);
        return redirect()->route('editProducts')->with('success', 'Новый продукт успешно создан и кэш сброшен!');
    }


    /**
     * Удаляет продукт, сброс кэша
     *
     * @param Product $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Product $product)
    {
        $this->productService->deleteProduct($product);
        return redirect()->route('editProducts')
            ->with('success', 'Продукт удалён и кэш сброшен');
    }


}
