<?php

namespace Tests\Unit;

use App\Models\Shop;
use App\Services\OpenCartService;
use PHPUnit\Framework\TestCase;

class OpenCartTest extends TestCase
{
    /**
     * @dataProvider totalPaymentDataProvider
     * @param float $total
     * @param float[] $expected_result
     * @return void
     */
    public function test_four_payments_from_total(float $total,array $expected_result): void
    {
        $shop = Shop::factory()->make();
        $open_cart = new OpenCartService($shop);
        $payments = $open_cart->getFourPaymentsFromTotal($total);

        $this->assertEqualsCanonicalizing($expected_result, $payments);
    }

    public static function totalPaymentDataProvider(): array
    {
        return [
            [100, [25, 25, 25, 25]],
            [107.53, [26.88, 26.88, 26.88, 26.89]],
            [0, [0, 0, 0, 0]],
        ];
    }
}
