<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateUserRequests;
use App\Http\Requests\User\LoginUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Passport\Token;
use Symfony\Component\HttpFoundation\Response;

class ApiAuthController extends Controller
{
    public function signup(CreateUserRequests $request): JsonResponse
    {
        $request['password'] = Hash::make($request->string('password')->trim());
        $request['remember_token'] = Str::random(10);
        $user = User::create($request->toArray());
        $user->createAsStripeCustomer();
        $token = $user->createToken('API Token')->accessToken;
        $response = ['token' => $token];

        return response()->json($response);
    }

    public function login(LoginUserRequest $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');

        if (auth('web')->attempt($credentials) === false) {
            return response()->json(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }
        /** @var User $user */
        $user = Auth::user();
        $accessToken = $user->createToken('API Token')->accessToken;

        return response()->json(['token' => $accessToken], Response::HTTP_OK);
    }

    public function logout(): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();
        /** @var array<Token> $tokens */
        $tokens = $user->tokens()->pluck('id');

        Token::whereIn('id', $tokens)->update(['revoked' => true]);

        $response = ['message' => 'You have been successfully logged out!'];

        return response()->json($response);
    }
}
