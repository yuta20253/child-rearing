<?php

namespace App\Services;

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
        $this->reviewRepository->create($facilityId, $userId, $comment, $rating);
    }

    public function updateReview(int $reviewId, string $comment, int $rating)
    {
        $userId = Auth::id();
        $this->reviewRepository->update($reviewId, $userId, $comment, $rating);
    }
}
