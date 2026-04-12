<?php

namespace App\Http\Controllers;

use App\Services\Review\ReviewService;
use App\Http\Requests\StoreReviewRequest;

class ReviewController extends Controller
{
    protected ReviewService $reviewService;

    public function __construct(ReviewService $reviewService)
    {
        $this->reviewService = $reviewService;
    }

    public function store(StoreReviewRequest $request)
    {
        $facilityId = $request->input('facility_id');
        $comment = $request->input('comment');
        $rating = $request->input('rating');
        $this->reviewService->createReview($facilityId, $comment, $rating);

        return response()->json(['message' => 'レビューを投稿しました。'], 201);
    }
}
