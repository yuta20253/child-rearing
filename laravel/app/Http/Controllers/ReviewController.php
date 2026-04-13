<?php

namespace App\Http\Controllers;

use App\Services\ReviewService;
use App\Models\Facility;
use App\Http\Requests\StoreReviewRequest;

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
