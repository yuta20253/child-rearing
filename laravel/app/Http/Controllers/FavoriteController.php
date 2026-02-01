<?php

namespace App\Http\Controllers;

use App\Services\FacilityService;
use App\Services\FacilityFavoriteService;
use Illuminate\Http\Request;

/**
 * @OA\POST(
 *     path="/api/facilities/{facilityId}/favorite",
 *     summary="施設お気に入り登録",
 *     operationId="RegisterFacilityFavorite",
 *     description="施設お気に入り登録",
 *     @OA\Parameter(
 *         name="facilityId",
 *         in="path",
 *         required=true,
 *         description="施設ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *        response=201,
 *        description="施設お気に入り登録成功",
 *        @OA\JsonContent(
 *           @OA\Property(property="message", type="string", example="お気に入り登録しました。")
 *        )
 *     )
 * )
 *
 * @OA\DELETE(
 *     path="/api/facilities/{facilityId}/favorite",
 *     summary="施設お気に入り解除",
 *     operationId="CancelFacilityFavorite",
 *     description="施設お気に入り解除",
 *     @OA\Parameter(
 *         name="facilityId",
 *         in="path",
 *         required=true,
 *         description="施設ID",
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *        response=201,
 *        description="施設お気に入り解除成功",
 *        @OA\JsonContent(
 *           @OA\Property(property="message", type="string", example="お気に入り解除しました。")
 *        )
 *     )
 * )
 */
class FavoriteController extends Controller
{
    protected FacilityFavoriteService $facilityFavoriteService;
    protected FacilityService $facilityService;

    public function __construct(
        FacilityFavoriteService $facilityFavoriteService,
        FacilityService $facilityService,
    ) {
        $this->facilityFavoriteService = $facilityFavoriteService;
        $this->facilityService = $facilityService;
    }

    public function index()
    {
        $facilityFavorites = $this->facilityFavoriteService->getFacilityFavorites();
        return response()->json(['facilityFavorites' => $facilityFavorites]);
    }

    public function store(string $facilityId)
    {
        $facility = $this->facilityService->find($facilityId);

        $this->facilityFavoriteService->register($facility->id);
        return response()->json(['message' => 'お気に入り登録しました。'], 201);
    }

    public function destroy(string $facilityId)
    {
        $facility = $this->facilityService->find($facilityId);

        $this->facilityFavoriteService->cancel(($facility->id));
        return response()->json(['message' => 'お気に入り解除しました。'], 201);
    }
}
