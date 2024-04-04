<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Services\OpenCartService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class OpenCartController extends Controller
{
    public function __construct(protected Shop $shop, protected OpenCartService $openCartService)
    {
    }

    public function getOrderInfo(int $order_id, int $shop_id): JsonResponse
    {
        $data = $this->openCartService->getOrderInfo($order_id, $shop_id);

        if ($data === null) {
            return response()->json(null, Response::HTTP_NOT_FOUND);
        }

        return response()->json($data);
    }

    public function confirmOrder(int $order_id, int $shop_id): JsonResponse
    {
        $response = $this->openCartService->confirmOrder($order_id, $shop_id);

        if ($response === null) {
            return response()->json(null, Response::HTTP_NOT_FOUND);
        }

        return response()->json($response);
    }
}
