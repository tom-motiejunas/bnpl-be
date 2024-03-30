<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class OpenCartController extends Controller
{
    public function __construct(protected Shop $shop)
    {
    }

    public function getOrderInfo(int $order_id, int $shop_id): JsonResponse
    {
        $shop = $this->shop::find($shop_id);

        if ($shop === null) {
            return response()->json(null, Response::HTTP_NOT_FOUND);
        }
        $api_key = Crypt::decrypt($shop->api_key);

        $response = Http::get('http://172.26.0.1/index.php?bnpl_key='.$api_key.'&route=api/custom.products&order_id='.$order_id);

        /** @var array<string, float|string|int> $data */
        $data = $response->json();
        $data['payments'] = ($this->getFourPaymentsFromTotal((float) $data['total']));

        return response()->json($data);
    }

    public function confirmOrder(int $order_id, int $shop_id): JsonResponse
    {
        $shop = $this->shop::find($shop_id);

        if ($shop === null) {
            return response()->json(null, Response::HTTP_NOT_FOUND);
        }
        $api_key = Crypt::decrypt($shop->api_key);
        $response = Http::post('http://172.26.0.1/index.php?bnpl_key='.$api_key.'&route=api/custom.products&order_id='.$order_id);

        return response()->json($response);
    }

    /**
     * @return array<float>
     */
    private function getFourPaymentsFromTotal(float $total): array
    {
        $payments = [];

        for ($i = 0; $i < 4; $i++) {
            if ($i === 3) {
                $last_payment = $total - $payments[0] - $payments[1] - $payments[2];
                $payments[] = (float) number_format($last_payment, 2, '.', '');
            } else {
                $payments[] = round($total / 4, 2);
            }
        }

        return $payments;
    }
}
