<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Shop;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;

class OpenCartService
{
    public function __construct(protected Shop $shop)
    {
    }

    /**
     * @return array<string, array<float>|float|int|string>|null
     */
    public function getOrderInfo(int $order_id, int $shop_id): ?array
    {
        $shop = $this->shop::find($shop_id);

        if ($shop === null) {
            return null;
        }
        $api_key = Crypt::decrypt($shop->api_key);
        $response = Http::get('http://172.26.0.1/index.php?bnpl_key='.$api_key.'&route=api/custom.products&order_id='.$order_id);

        /** @var array<string, float|string|int> $data */
        $data = $response->json();
        $data['payments'] = ($this->getFourPaymentsFromTotal((float) $data['total']));

        return $data;
    }

    public function confirmOrder(int $order_id, int $shop_id): ?Response
    {
        $shop = $this->shop::find($shop_id);

        if ($shop === null) {
            return null;
        }
        $api_key = Crypt::decrypt($shop->api_key);

        return Http::post('http://172.26.0.1/index.php?bnpl_key='.$api_key.'&route=api/custom.products&order_id='.$order_id);
    }

    /**
     * @return array<float>
     */
    public function getFourPaymentsFromTotal(float $total): array
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
