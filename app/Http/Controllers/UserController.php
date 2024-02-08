<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\CreateUserRequests;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(CreateUserRequests $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:4|confirmed',
        ]);

        $user = User::create([
            'email' => $request->string('email')->trim(),
            'password' => bcrypt($request->string('password')->trim()),
        ]);

        return response()->json($user);
    }

}
