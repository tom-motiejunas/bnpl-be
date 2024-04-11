<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers;

use App\Models\Shop;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Testing\PendingCommand;
use Laravel\Passport\Passport;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class UserLoanTest extends TestCase
{
    use RefreshDatabase;

    protected Shop $shop;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->shop = Shop::factory()->create(['api_key' => Crypt::encrypt(env('OPEN_CART_TEST_API_KEY'))]);
        $this->user = User::factory()->create();

        Passport::actingAs(
            $this->user,
            ['api']
        );
    }

    public function test_user_loan_test(): void
    {
        $test_order_id = 19;
        $test_payment_method = 'pm_card_visa';
        $response = $this
            ->postJson('/api/confirm-order', [
                'payment_method_id' => $test_payment_method,
                'order_id' => $test_order_id,
                'shop_id' => $this->shop->id,
            ]);

        $response
            ->assertStatus(Response::HTTP_OK)
            ->assertJson(['data' => [
                'payment_method_id' => $test_payment_method,
                'order_id' => $test_order_id,
                'shop_id' => $this->shop->id,
                'user_id' => $this->user->id,
                'last_payment' => date('Y-m-d'),
                'next_payment' => date('Y-m-d', strtotime('+2 weeks')),
            ]]);

        $confirm_response = $this->get('/api/order/'.$test_order_id.'/is-confirmed');
        $confirm_response->assertOk()->assertJsonStructure(['is_confirmed']);
    }

    public function test_collect_loans(): void
    {
        /** @var PendingCommand $response */
        $response = $this->artisan('app:collect-loans');
        $response->doesntExpectOutput('')->assertExitCode(0);
    }
}
