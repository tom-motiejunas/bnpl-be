<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\AddPaymentMethodRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserPaymentController extends Controller
{
    public function index(): JsonResponse
    {
        /** @var User $user */
        $user = auth()->user();

        return response()->json($user->paymentMethods());
    }

    public function store(AddPaymentMethodRequest $addPaymentMethodRequest): JsonResponse
    {
        /** @var User $user */
        $user = $addPaymentMethodRequest->user();
        $user->addPaymentMethod($addPaymentMethodRequest->string('paymentMethodIdentifier'));

        return response()->json('success');
    }
}
