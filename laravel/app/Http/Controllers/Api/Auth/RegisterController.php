<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterFormRequest;
use App\Models\User;

class RegisterController extends Controller
{
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function register(RegisterFormRequest $request)
    {
        $form = $request->only(['name', 'email', 'password']);

        $user = $this->user->create([
            'name' => $form['name'],
            'email' => $form['email'],
            'password' => $form['password'],
            'role' => 'member',
        ]);

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ], 201);
    }
}
