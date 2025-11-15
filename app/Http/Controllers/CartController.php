<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use App\Services\DTO\AddProductDTO;
use App\Services\DTO\DecreaseProductDTO;
use Illuminate\Http\Request;

/**
 * Контроллер корзины
 */
class CartController
{
    protected cartService $cartService;
    public function __construct(cartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|object
     * Отдает страницу корзины пользователя
     */
    public function getCart()//нужно ли чтото возвращать?
    {
        $userProducts = $this->cartService->getUserProductsWithSum();
        $totalSum = $this->cartService->getTotalSum();
        return view('cart', ['userProducts' => $userProducts, 'totalSum' => $totalSum]);
    }

    /**
     * @param Request $request
     * @return void
     * Кнопка "+" у товара
     * Добавляет продукт в корзину по одному.
     */
    public function addProductToCart(Request $request)
    {
        $dto = AddProductDTO::fromRequest($request);
        $this->cartService->addProductToCart($dto);
    }

    /**
     * @param Request $request
     * @return void
     * Кнопка "-" у товара
     * Убавляет продукт из корзины по одному
     */
    public function decreaseProductFromCart(Request $request)
    {
        $dto = DecreaseProductDTO::fromRequest($request);
        $this->cartService->decreaseProductFromCart($dto);
    }
}
