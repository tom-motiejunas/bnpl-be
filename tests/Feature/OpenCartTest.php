<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Shop;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Crypt;
use Laravel\Passport\Passport;
use Tests\TestCase;

class OpenCartTest extends TestCase
{
    use RefreshDatabase;

    public function test_open_cart(): void
    {
        $shop = Shop::factory()->create(['api_key' => Crypt::encrypt(env('OPEN_CART_TEST_API_KEY'))]);
        Passport::actingAs(
            User::factory()->create(),
            ['api']
        );
        $response_found = $this->get('/api/get-order/1/shop/'.$shop->id);
        $response_order_not_found = $this->get('/api/get-order/9999999/shop/'.$shop->id);
        $response_shop_not_found = $this->get('/api/get-order/1/shop/9999999');

        $response_found->assertOk();
        $response_order_not_found->assertNotFound();
        $response_shop_not_found->assertNotFound();
    }
}
