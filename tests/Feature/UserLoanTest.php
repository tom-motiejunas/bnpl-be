<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Shop;
use App\Models\User;
use Laravel\Passport\Passport;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class UserLoanTest extends TestCase
{
    public function test_user_loan_test(): void
    {
        $user = User::factory()->create();
        Passport::actingAs(
            $user,
            ['api']
        );
        $shop = Shop::factory()->create();
        $test_order_id = 1;
        $test_payment_method = 'pm_card_visa';
        $response = $this
            ->postJson('/api/confirm-order', [
                'payment_method_id' => $test_payment_method,
                'order_id' => $test_order_id,
                'shop_id' => $shop->id,
            ]);

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJson(['data' => [
                'payment_method_id' => $test_payment_method,
                'order_id' => $test_order_id,
                'shop_id' => $shop->id,
                'user_id' => $user->id,
                'last_payment' => date('Y-m-d'),
                'next_payment' => date('Y-m-d', strtotime('+2 weeks')),
            ]]);
    }
}
