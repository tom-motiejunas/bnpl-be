<?php

namespace Tests\Unit;

use App\Models\Shop;
use App\Services\OpenCartService;
use PHPUnit\Framework\TestCase;

class OpenCartTest extends TestCase
{
    public function test_four_payments_from_total(): void
    {
        $shop = Shop::factory()->make();
        $open_cart = new OpenCartService($shop);
        $payments = $open_cart->getFourPaymentsFromTotal(100);
        $payments_2 = $open_cart->getFourPaymentsFromTotal(107.53);
        $payments_3 = $open_cart->getFourPaymentsFromTotal(0);

        $this->assertEqualsCanonicalizing([25, 25, 25, 25], $payments);
        $this->assertEqualsCanonicalizing([26.88, 26.88, 26.88, 26.89], $payments_2);
        $this->assertEqualsCanonicalizing([0, 0, 0, 0], $payments_3);
    }
}
