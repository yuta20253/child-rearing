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
use OpenApi\Annotations as OA;

/**
 * @OA\Post(
 *      path="/login",
 *      summary="ログイン",
 *      description="メールアドレスとパスワードでログインし、認証トークンを返す",
 *      operationId="loginUser",
 *      tags={"Auth"},
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(
 *              type="object",
 *              required={"email", "password"},
 *              @OA\Property(property="email", type="string", format="email", example="test@example.com"),
 *              @OA\Property(property="password", type="string", format="password", example="password123")
 *          )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="認証成功",
 *          @OA\JsonContent(
 *              type="object",
 *              @OA\Property(property="user", ref="#/components/schemas/User"),
 *              @OA\Property(property="token", type="string", example="1|eyJhbGciOiJIUzI1NiIsInR5cCI6")
 *              )
 *          ),
 *      @OA\Response(
 *          response=401,
 *          description="認証失敗",
 *          @OA\JsonContent(
 *              @OA\Property(property="message", type="string", example="認証が失敗しました。")
 *          )
 *      )
 * )
 *
 * @OA\Delete(
 *     path="/logout",
 *     summary="ログアウト",
 *     tags={"Auth"},
 *     @OA\Response(
 *         response=200,
 *         description="ログアウト成功",
 *         @OA\JsonContent(
 *            @OA\Property(property="message", type="string", example="ログアウトしました。")
 *         )
 *     )
 * )
* @OA\Post(
 *      path="/password/reset/request",
 *      summary="パスワードリセットメール送信",
 *      tags={"Auth"},
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(
 *              type="object",
 *              required={"email"},
 *              @OA\Property(property="email", type="string", format="email", example="test@example.com")
 *          )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="メール送信完了",
 *          @OA\JsonContent(
 *              @OA\Property(property="mail_sent", type="boolean", example=true)
 *          )
 *      ),
 *      @OA\Response(
 *          response=404,
 *          description="メールアドレス未登録",
 *          @OA\JsonContent(
 *              @OA\Property(property="error", type="string", example="メールアドレスが見つかりません。")
 *          )
 *      )
 * )
 *
 * @OA\Post(
 *      path="/password/reset/verify",
 *      summary="パスワードリセット用トークンとメール検証",
 *      tags={"Auth"},
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(
 *              type="object",
 *              required={"token", "email"},
 *              @OA\Property(property="token", type="string", example="abc123token"),
 *              @OA\Property(property="email", type="string", format="email", example="test@example.com")
 *          )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="検証成功",
 *          @OA\JsonContent(
 *              @OA\Property(property="verified", type="boolean", example=true)
 *          )
 *      ),
 *      @OA\Response(
 *          response=400,
 *          description="検証失敗",
 *          @OA\JsonContent(
 *              @OA\Property(property="message", type="string", example="不正なトークンです。")
 *          )
 *      )
 * )
 *
 * @OA\Post(
 *      path="/password/reset",
 *      summary="パスワード更新",
 *      tags={"Auth"},
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(
 *              type="object",
 *              required={"token", "email", "password"},
 *              @OA\Property(property="token", type="string", example="abc123token"),
 *              @OA\Property(property="email", type="string", format="email", example="test@example.com"),
 *              @OA\Property(property="password", type="string", format="password", example="newPassword123")
 *          )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="パスワード更新成功",
 *          @OA\JsonContent(
 *              @OA\Property(property="message", type="string", example="パスワードを更新しました。")
 *          )
 *      ),
 *      @OA\Response(
 *          response=400,
 *          description="更新失敗",
 *          @OA\JsonContent(
 *              @OA\Property(property="message", type="string", example="不正なトークンです。")
 *          )
 *      )
 * )
 */
class AuthController extends Controller
{
    public function login(LoginFormRequest $request)
    {
        // $credentials = $request->only(['email', 'password']);

        $user = User::where('email', $request->email)->first();
        if (! Hash::check($request->password, $user->password)) {
            return response()->json(['message' => '認証が失敗しました。'], 401);
        }

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
        $expire_at = $now->addHour(1);

        UserToken::create([
            'user_id' => $user->id,
            'token' => $token,
            'expire_at' => $expire_at,
        ]);

        $user->sendPasswordResetNotification($token);

        return new JsonResponse([
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
