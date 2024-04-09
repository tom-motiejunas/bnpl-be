<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class UserPaymentTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();
        $user->createAsStripeCustomer();
        Passport::actingAs(
            $user,
            ['api']
        );
    }

    public function test_payment(): void
    {
        $response_added = $this->postJson('/api/add-payment', [
            'paymentMethodIdentifier' => 'pm_card_visa',
        ]);
        $response_get_all = $this->get('/api/get-payments');

        $response_added->assertStatus(Response::HTTP_CREATED);
        $response_get_all->assertStatus(Response::HTTP_OK)->assertJsonStructure([
            '*' => [
                'id',
                'object',
                'created',
                'customer',
            ],
        ]);
    }
}
