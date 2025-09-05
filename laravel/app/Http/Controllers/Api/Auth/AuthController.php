<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginFormRequest;
use App\Http\Requests\SendPasswordResetEmailRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Models\User;
use App\Models\UserToken;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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

    public function sendPasswordResetEmail(SendPasswordResetEmailRequest $request)
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

    // パスワード再設定画面でトークンとメールアドレスを検証する処理
    public function verifyTokenAndEmail(Request $request)
    {
        $result = $this->validateResetToken($request->token, $request->email);

        if (! $result['success']) {
            return new JsonResponse(['message' => $result['message']]);
        }

        return new JsonResponse([
            'token' => $request->token,
            'verified' => true
        ]);
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $result = $this->validateResetToken($request->token, $request->email);

        if (! $result['success']) {
            return new JsonResponse(['message' => $result['message']]);
        }

        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        // パスワードを変更したらトークンは削除する
        UserToken::where('token', $request->token)->delete();

        return new JsonResponse([
            'message' => 'パスワードを更新しました。'
        ]);

    }

    private function validateResetToken($token, $email)
    {
        $dbToken = UserToken::where('token', $token)->first();
        if (! $dbToken) {
            return ['success' => false, 'message' => '不正なトークンです。'];
        }

        $user = User::where('email', $email)->first();
        if (! $user) {
            return ['success' => false, 'message' => 'メールアドレスが見つかりません。'];
        }

        $now = Carbon::now();
        if ($now->gt($dbToken->expire_at)) {
            return ['success' => false, 'message' => 'トークンの有効期限が切れています。'];
        }

        if ($dbToken->user_id != $user->id) {
            return ['success' => false, 'message' => '不正なトークンです。'];
        }

        return ['success' => true];
    }

}
