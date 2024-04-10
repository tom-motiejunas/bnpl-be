<?php

namespace App\Http\Controllers;

use App\Http\Requests\DestroyPaymentMethodRequest;
use App\Http\Requests\User\AddPaymentMethodRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class UserPaymentController extends Controller
{
    public function index(): JsonResponse
    {
        /** @var User $user */
        $user = auth()->user();

        return response()->json($user->paymentMethods());
    }

    public function store(AddPaymentMethodRequest $add_payment_method_request): JsonResponse
    {
        /** @var User $user */
        $user = $add_payment_method_request->user();
        $user->addPaymentMethod($add_payment_method_request->string('paymentMethodIdentifier'));

        return response()->json('success', Response::HTTP_CREATED);
    }

    public function destroy(DestroyPaymentMethodRequest $destroy_payment_method_request): JsonResponse
    {
        /** @var User $user */
        $user = $destroy_payment_method_request->user();
        $user->deletePaymentMethod($destroy_payment_method_request->string('paymentMethodIdentifier'));

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
