<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 * @OA\Get(
 *     path="/api/profile",
 *     summary="現在のユーザー自身",
 *     operationId="myProfile",
 *     description="現在のユーザー自身の取得",
 *     tags={"User"},
 *     @OA\Response(
 *        response=200,
 *        description="ユーザー取得成功",
 *        @OA\JsonContent(
 *           @OA\Property(property="user", ref="#/components/schemas/User")
 *        )
 *     )
 * )
 */
class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function profile()
    {
        $user = $this->userService->getCurrentUser();
        return response()->json(['user' => new UserResource($user)]);
    }
}
