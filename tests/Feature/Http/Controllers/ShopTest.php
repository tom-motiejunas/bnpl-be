<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ShopTest extends TestCase
{
    use RefreshDatabase;

    public function test_shop(): void
    {
        $test_api_key = fake()->regexify('[A-Za-z0-9]{10}');
        $response_added = $this->postJson('/api/add-shop', ['api_key' => $test_api_key]);
        $response_removed = $this->delete('/api/remove-shop');

        $response_added->assertStatus(Response::HTTP_CREATED);
        $response_removed->assertNoContent();
    }
}
