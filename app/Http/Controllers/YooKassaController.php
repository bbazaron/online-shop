<?php

namespace App\Http\Controllers;

use App\Services\YooKassaService;
use Illuminate\Http\Request;

//use Illuminate\Support\Facades\Request;

/**
 * Контроллер отвечающий за Юкассу
 */
class YooKassaController
{
    private YooKassaService $yooKassaService;
    public function __construct(YooKassaService $yooKassaService)
    {
        $this->yooKassaService = $yooKassaService;
    }

    /**
     * Обрабатывает вебхук
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handle(Request $request)
    {
        $this->yooKassaService->handleWebhook($request);
        return response()->json(['status' => 'ok']);
    }

}
