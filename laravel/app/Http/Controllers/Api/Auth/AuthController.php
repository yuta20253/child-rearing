<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginFormRequest;
use App\Models\User;
use App\Models\UserToken;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    public function login(LoginFormRequest $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (! Auth::attempt($credentials)) {
            return response()->json(['message' => '認証が失敗しました。'], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ], 200);
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $user->currentAccessToken()->delete();

        return response()->json(['message' => 'ログアウトしました。']);
    }

    public function sendPasswordResetEmail(Request $request)
    {
        $user = User::where('email', $request->input('email'))->first();
        if (! $user) {
            return response()->json(['error' => 'メールアドレスが見つかりません。']);
        }

        $token = Password::broker()->createToken($user);
        $now = Carbon::now();
        $expire_at = $now->addHour(1)->toDateString();

        UserToken::create([
            'user_id' => $user->id,
            'token' => $token,
            'expire_at' => $expire_at,
        ]);

        $user->sendPasswordResetNotification($token);

        return new JsonResponse([
            'token' => $token,
            'mail_sent' => true,
        ]);
    }

}
