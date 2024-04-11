<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\Passport;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration(): void
    {
        \Artisan::call('passport:install');

        $response = $this->withHeaders(['Accept' => 'application/json', 'Content-Type' => 'application/json'])
            ->postJson('/api/sign-up', [
                'email' => 'test21@test.com',
                'password' => 'test123',
            ]);

        $response->assertOk();
    }

    public function test_login(): void
    {
        \Artisan::call('passport:install');
        $user = User::factory()->create(['password' => Hash::make('test123')]);
        Passport::actingAs($user);

        $response = $this->withHeaders(['Accept' => 'application/json', 'Content-Type' => 'application/json'])
            ->postJson('/api/log-in', [
                'email' => $user->email,
                'password' => 'test123',
            ]);
        $response_2 = $this->withHeaders(['Accept' => 'application/json', 'Content-Type' => 'application/json'])
            ->postJson('/api/log-in', [
                'email' => $user->email,
                'password' => '123test',
            ]);

        $response->assertOk();
        $response->assertJsonStructure(['token']);

        $response_2->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_logout(): void
    {
        \Artisan::call('passport:install');
        $user = User::factory()->create(['password' => Hash::make('test123')]);
        Passport::actingAs($user);

        $login_response = $this->withHeaders(['Accept' => 'application/json', 'Content-Type' => 'application/json'])
            ->postJson('/api/log-in', [
                'email' => $user->email,
                'password' => 'test123',
            ]);

        $response = $this->withHeaders(['Authorization' => 'Bearer '.$login_response->json('token'),
            'Content-Type' => 'application/json',
        ])->postJson('/api/log-out', []);

        $response->assertOk();
    }
}
