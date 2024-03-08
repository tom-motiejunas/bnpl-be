<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\AddUserLoanRequest;
use App\Models\User;
use App\Models\UserLoan;
use Illuminate\Http\JsonResponse;

class UserLoanController extends Controller
{
    public function __construct(protected OpenCartController $openCartController)
    {
    }

    public function store(AddUserLoanRequest $addUserLoanRequest): JsonResponse
    {
        /** @var User $user */
        $user = $addUserLoanRequest->user();

        /** @var array<string, float[]> $order */
        $order = $this->openCartController->getOrderInfo($addUserLoanRequest->integer('order_id'))->original;
        $first_payment = (int) $order['payments'][0];

        $user->charge($first_payment * 100, (string) $addUserLoanRequest->string('payment_method_id'), [
            'return_url' => route('order.success'),
        ]);

        $newUserLoan = $addUserLoanRequest->all();
        $newUserLoan['user_id'] = $user['id'];
        $newUserLoan['payment_method_id'] = $addUserLoanRequest->string('payment_method_id');
        $newUserLoan['last_payment'] = date('Y-m-d');
        $newUserLoan['next_payment'] = date('Y-m-d', strtotime('+2 weeks'));
        $newUserLoan['total'] = $order['total'];
        $newUserLoan['total_paid'] = $first_payment;
        $newUserLoan['order_id'] = $addUserLoanRequest->integer('order_id');

        UserLoan::create($newUserLoan);

        return response()->json(['data' => $newUserLoan, 'response' => 'success']);
    }
}
