<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\AddUserLoanRequest;
use App\Models\User;
use App\Models\UserLoan;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class UserLoanController extends Controller
{
    public function __construct(protected OpenCartController $open_cart_controller)
    {
    }

    public function store(AddUserLoanRequest $add_user_loan_request): JsonResponse
    {
        /** @var User $user */
        $user = $add_user_loan_request->user();

        /** @var array<string, float[]> $order */
        $order = $this->open_cart_controller->getOrderInfo($add_user_loan_request->integer('order_id'))->original;
        $first_payment = (int) $order['payments'][0];

        $user->charge($first_payment * 100, (string) $add_user_loan_request->string('payment_method_id'), [
            'return_url' => route('order.success'),
        ]);

        $new_user_loan = $add_user_loan_request->all();
        $new_user_loan['user_id'] = $user['id'];
        $new_user_loan['payment_method_id'] = $add_user_loan_request->string('payment_method_id');
        $new_user_loan['last_payment'] = date('Y-m-d');
        $new_user_loan['next_payment'] = date('Y-m-d', strtotime('+2 weeks'));
        $new_user_loan['total'] = $order['total'];
        $new_user_loan['total_paid'] = $first_payment;
        $new_user_loan['order_id'] = $add_user_loan_request->integer('order_id');

        UserLoan::create($new_user_loan);
        $this->open_cart_controller->confirmOrder($add_user_loan_request->integer('order_id'));

        return response()->json(['data' => $new_user_loan, 'response' => 'success']);
    }

    public function isConfirmed(int $order_id): JsonResponse
    {
        $user_loan = UserLoan::where('order_id', $order_id)->first();
        if ($user_loan === null) {
            return response()->json(['is_confirmed' => false], Response::HTTP_NOT_FOUND);
        }

        return response()->json(['is_confirmed' => true]);
    }
}
