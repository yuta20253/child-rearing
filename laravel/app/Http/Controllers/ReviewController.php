<?php

namespace App\Http\Controllers;

use App\Services\ReviewService;
use App\Models\Facility;
use App\Models\FacilityReview;
use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;

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
 * @OA\PATCH(
 *   path="/api/reviews/{review}",
 *   summary="レビュー更新",
 *   operationId="UpdateReview",
 *   tags={"Review"},
 *
 *   @OA\Parameter(
 *     name="review",
 *     in="path",
 *     required=true,
 *     description="レビューID",
 *     @OA\Schema(type="integer", example=1)
 *   ),
 *
 *   @OA\RequestBody(
 *     required=true,
 *     @OA\JsonContent(
 *       required={"comment","rating"},
 *       @OA\Property(
 *         property="comment",
 *         type="string",
 *         example="スタッフの対応が良かったです"
 *       ),
 *       @OA\Property(
 *         property="rating",
 *         type="integer",
 *         example=4
 *       )
 *     )
 *   ),
 *
 *   @OA\Response(
 *     response=200,
 *     description="レビュー更新成功",
 *     @OA\JsonContent(
 *       @OA\Property(
 *         property="message",
 *         type="string",
 *         example="レビューを更新しました"
 *       )
 *     )
 *   ),
 *
 *   @OA\Response(
 *     response=404,
 *     description="レビューが存在しない、または更新権限がない"
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

    public function update(UpdateReviewRequest $request, FacilityReview $review)
    {
        $comment = $request->input('comment');
        $rating = $request->input('rating');

        $reviewId = $review->id;

        $this->reviewService->updateReview($reviewId, $comment, $rating);

        return response()->json(['message' => 'レビューを更新しました'], 200);
    }
}
