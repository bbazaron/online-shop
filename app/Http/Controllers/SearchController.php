<?php

namespace App\Http\Controllers;

use App\Services\DTO\SearchProductDTO;
use App\Services\SearchService;
use Illuminate\Http\Request;

/**
 * Контроллер отвечающий за поиск товаров на сайте
 */
class SearchController
{
    private SearchService $searchService;

    public function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;
    }

    /** Поиск товаров на сайте
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Http\JsonResponse|\Illuminate\Support\Collection|object
     */
    public function search(Request $request)
    {
        $dto = SearchProductDTO::fromRequest($request);
        if ($request->ajax()) {
            return $this->searchService->searchProduct($dto);
        }

        $products = $this->searchService->searchProduct($dto);
        return view('catalog', compact('products'));
    }

}
