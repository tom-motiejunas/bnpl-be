<?php

namespace Database\Factories;

use App\Models\UserLoan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<UserLoan>
 */
class UserLoanFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => 1,
            'order_id' => 1,
            'last_payment' => now(),
            'next_payment' => now(),
            'amount' => 100,
            'total' => 100,
            'total_paid' => 0,
            'instalment' => 0,
            'total_instalment' => 4,
            'payment_method_id' => 1,
        ];
    }
}
