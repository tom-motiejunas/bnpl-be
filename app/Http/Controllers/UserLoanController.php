<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\AddUserLoanRequest;
use App\Models\User;
use App\Models\UserLoan;
use Illuminate\Http\JsonResponse;

class UserLoanController extends Controller
{
    public function create(AddUserLoanRequest $addUserLoanRequest): JsonResponse
    {
        /** @var User $user */
        $user = $addUserLoanRequest->user();
        $newUserLoan = $addUserLoanRequest->all();
        $newUserLoan['user_id'] = $user['id'];
        $newUserLoan['next_payment'] = date('Y-m-d', strtotime('+2 weeks'));
        $newUserLoan['paymentMethodId'] = $addUserLoanRequest->string('paymentMethodId');
        $user->charge(100, $newUserLoan['paymentMethodId']);

        $newUserLoan['last_payment'] = date('Y-m-d');
        UserLoan::create($newUserLoan);

        return response()->json(['data' => $newUserLoan, 'response' => 'success']);
    }
}
