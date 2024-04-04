<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Shop;
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
            'shop_id' => fake()->randomDigit(),
            'api_key' => fake()->regexify('[A-Za-z0-9]{50}'),
            'domain' => fake()->domainName(),
        ];
    }
}
