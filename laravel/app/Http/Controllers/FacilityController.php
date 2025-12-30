<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use App\Services\FacilityService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 * @OA\Get(
 *     path="/api/facilities",
 *     summary="施設一覧",
 *     operationId="FacilitiesInfo",
 *     description="施設一覧の取得",
 *     tags={"Facility"},
 *     @OA\Parameter(
 *         name="name",
 *         in="query",
 *         required=false,
 *         description="施設名での検索キーワード",
 *         @OA\Schema(type="string", example="北区")
 *     ),
 *     @OA\Response(
 *        response=200,
 *        description="施設一覧取得成功",
 *        @OA\JsonContent(
 *           @OA\Property(property="facilities", type="array", @OA\Items(ref="#/components/schemas/Facility"))
 *        )
 *     )
 * )
 * @OA\Get(
 *     path="/api/facilities/{id}",
 *     summary="施設詳細",
 *     operationId="FacilityInfo",
 *     description="施設詳細の取得",
 *     tags={"Facility"},
 *     @OA\Parameter(
 *        name="id",
 *        in="path",
 *        required=true,
 *        description="施設ID",
 *        @OA\Schema(type="integer", example=1)
 *     ),
 *     @OA\Response(
 *        response=200,
 *        description="施設詳細取得成功",
 *        @OA\JsonContent(
 *           @OA\Property(property="facility", ref="#/components/schemas/Facility")
 *        )
 *     ),
 *     @OA\Response(
 *        response=404,
 *        description="施設が見つからない場合",
 *        @OA\JsonContent(
 *           @OA\Property(property="message", type="string", example="該当の施設が見つかりません。")
 *        )
 *     )
 * )
 */
class FacilityController extends Controller
{
    private FacilityService $facilityService;

    public function __construct(FacilityService $facilityService)
    {
        $this->facilityService = $facilityService;
    }

    public function index(Request $request)
    {
        $query = $request->query('name');
        $facilities = $this->facilityService->getAll($query);
        return response()->json([
            "facilities" => $facilities,
        ], 200);
    }

    public function show(Facility $facility)
    {
        try {
            $facilityDetail = $this->facilityService->find($facility->id);
            return response()->json(['facility' => $facilityDetail], 200);
        } catch (ModelNotFoundException) {
            return response()->json(['message' => '該当の施設が見つかりません。'], 404);
        }
    }
}
