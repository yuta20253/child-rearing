<?php

namespace App\Http\Controllers;

use App\Services\ReviewService;
use App\Models\Facility;
use App\Http\Requests\StoreReviewRequest;

/**
 * @OA\Post(
 *   path="/api/facilities/{facility}/review",
 *   summary="施設のレビュー投稿",
 *   operationId="PostFacilityReview",
 *   tags={"Review"},
 *
 *   @OA\Parameter(
 *     name="facility",
 *     in="path",
 *     required=true,
 *     description="施設ID",
 *     @OA\Schema(type="integer", example=1)
 *   ),
 *
 *   @OA\RequestBody(
 *     required=true,
 *     @OA\JsonContent(
 *       required={"comment","rating"},
 *       @OA\Property(property="comment", type="string", example="とても綺麗でした"),
 *       @OA\Property(property="rating", type="integer", example=5)
 *     )
 *   ),
 *
 *   @OA\Response(
 *     response=201,
 *     description="レビュー投稿成功",
 *     @OA\JsonContent(
 *       @OA\Property(property="message", type="string", example="レビューを投稿しました。")
 *     )
 *   )
 * )
 */
class ReviewController extends Controller
{
    protected ReviewService $reviewService;

    public function __construct(ReviewService $reviewService)
    {
        $this->reviewService = $reviewService;
    }

    public function store(StoreReviewRequest $request, Facility $facility)
    {
        $comment = $request->input('comment');
        $rating = $request->input('rating');

        $facilityId = $facility->id;

        $this->reviewService->createReview($facilityId, $comment, $rating);

        return response()->json(['message' => 'レビューを投稿しました。'], 201);
    }
}
