<?php

namespace Tests\Unit;

use App\Http\Controllers\UserLoanController;
use App\Models\Shop;
use App\Models\UserLoan;
use App\Services\OpenCartService;
use PHPUnit\Framework\TestCase;

class UserLoanTest extends TestCase
{
    protected UserLoanController $user_loan_controller;

    protected function setUp(): void
    {
        parent::setUp();

        $shop = Shop::factory()->make();
        $open_cart = new OpenCartService($shop);
        $this->user_loan_controller = new UserLoanController($open_cart);
    }

    /**
     * @dataProvider userLoanDataProvider
     * @param array<string, string> $user_loan_data
     * @param float $expected_results
     * @return void
     */
    public function test_get_loan_payment(array $user_loan_data, float $expected_results): void
    {
        $user_loan = UserLoan::factory()->make($user_loan_data);
        $payment = $this->user_loan_controller->getLoanPayment($user_loan);
        $this->assertSame($expected_results, $payment);
    }

    public static function userLoanDataProvider(): array
    {
        return [
            [['user_id' => 1,
                'order_id' => 1,
                'last_payment' => now(),
                'next_payment' => now(),
                'amount' => 100,
                'total' => 100,
                'total_paid' => 0,
                'instalment' => 0,
                'total_instalment' => 4,
                'payment_method_id' => 1,], 25.00],
            [['user_id' => 1,
                'order_id' => 1,
                'last_payment' => now(),
                'next_payment' => now(),
                'amount' => 100,
                'total' => 110.07,
                'total_paid' => 75,
                'instalment' => 3,
                'total_instalment' => 4,
                'payment_method_id' => 1,], 35.07]
        ];
    }
}
