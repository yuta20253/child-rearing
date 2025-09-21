<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterFormRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use OpenApi\Annotations as OA;

/**
 * @OA\Post(
 *     path="/api/register",
 *     summary="新規登録",
 *     description="ユーザーの新規登録を行う",
 *     tags={"Register"},
 *     @OA\RequestBody(
 *        required=true,
 *        @OA\JsonContent(
 *              type="object",
 *              required={"name", "email", "password"},
 *              @OA\Property(property="name", type="string", example="test User"),
 *              @OA\Property(property="email", type="string", format="email", example="test@example.com"),
 *              @OA\Property(property="password", type="string", format="password", example="password123")
 *        )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="新規登録成功",
 *         @OA\JsonContent(
 *              type="object",
 *              @OA\Property(property="user", ref="#/components/schemas/User"),
 *              @OA\Property(property="token", type="string", example="1|eyJhbGciOiJIUzI1NiIsInR5cCI6")
 *         )
 *     )
 * )
 *
 * @OA\Delete(
 *     path="/api/delete-account",
 *     summary="退会",
 *     description="ユーザーが退会処理をする",
 *     tags={"Register"},
 *     @OA\Response(
 *         response=200,
 *         description="退会成功",
 *         @OA\JsonContent(
 *            @OA\Property(property="message", type="string", example="ログアウトしました。")
 *         )
 *     )
 * )
 */
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
            'password' => Hash::make($form['password']),
            'role' => 'member',
        ]);

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ], 200);
    }

    public function accountDelete(Request $request)
    {
        $user = $request->user();
        $user->update([
            'name' => $user->maskedName(),
            'email' => $user->maskedEmail(),
        ]);
        $user->delete();
        return response()->json([
            'message' => 'アカウントを削除しました。'
        ], 200);
    }
}
