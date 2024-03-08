<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;

class OpenCartController extends Controller
{
    public function login(): string
    {
        $response = Http::asForm()
            ->post('http://172.26.0.1/index.php?route=api/account/login', [
                'key' => env('OPEN_CART_KEY'),
                'username' => 'Default',
            ]);
        /** @var string $token */
        $token = $response['api_token'];

        return $token;
    }

    public function getOrderInfo(int $orderId): JsonResponse
    {
        $token = $this->login();

        $response = Http::withCookies([
            'OCSESSID' => $token,
        ], '172.26.0.1')->get('http://172.26.0.1/index.php?route=api/sale/order&order_id='.$orderId);

        /** @var array<string, float|string|int> $data */
        $data = $response->json();
        $data['payments'] = ($this->getFourPaymentsFromTotal((float) $data['total']));

        return response()->json($data);
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
