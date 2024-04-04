<?php

namespace Tests\Unit;

use App\Http\Controllers\UserLoanController;
use App\Models\Shop;
use App\Models\UserLoan;
use App\Services\OpenCartService;
use PHPUnit\Framework\TestCase;

class UserLoanTest extends TestCase
{
    public function test_getLoanPayment(): void
    {
        $shop = Shop::factory()->make();
        $open_cart = new OpenCartService($shop);
        $user_loan_controller = new UserLoanController($open_cart);
        $user_loan = UserLoan::factory()->make([
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
        ]);
        $user_loan_2 = UserLoan::factory()->make([
            'user_id' => 1,
            'order_id' => 1,
            'last_payment' => now(),
            'next_payment' => now(),
            'amount' => 100,
            'total' => 110.07,
            'total_paid' => 75,
            'instalment' => 3,
            'total_instalment' => 4,
            'payment_method_id' => 1,
        ]);

        $payment = $user_loan_controller->getLoanPayment($user_loan);
        $payment_2 = $user_loan_controller->getLoanPayment($user_loan_2);

        $this->assertEquals(25.00, $payment);
        $this->assertEquals(35.07, $payment_2);
    }
}