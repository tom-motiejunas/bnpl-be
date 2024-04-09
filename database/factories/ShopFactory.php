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
    protected static ?string $api_key;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => fake()->randomDigit(),
            'api_key' => static::$api_key ??= fake()->regexify('a-z{20}'),
            'domain' => fake()->domainName(),
        ];
    }
}
