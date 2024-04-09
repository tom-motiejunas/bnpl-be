<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Shop;
use Crypt;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Shop>
 */
class ShopFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => fake()->randomDigit(),
            'api_key' => Crypt::encrypt(env('OPEN_CART_TEST_API_KEY')),
            'domain' => fake()->domainName(),
        ];
    }
}
