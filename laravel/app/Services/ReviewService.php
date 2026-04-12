<?php

namespace App\Services\Review;

use App\Repositories\Review\ReviewRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class ReviewService
{
    private ReviewRepositoryInterface $reviewRepository;

    public function __construct(ReviewRepositoryInterface $reviewRepository)
    {
        $this->reviewRepository = $reviewRepository;
    }

    public function createReview(int $facilityId, string $comment, int $rating)
    {
        $userId = Auth::id();
        $this->reviewRepository->store($facilityId, $userId, $comment, $rating);
    }
}
