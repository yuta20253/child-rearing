<?php

namespace App\Repositories\Review;

use App\Enums\ReviewStatus;
use App\Models\User;
use App\Repositories\Review\ReviewRepositoryInterface;

class ReviewRepository implements ReviewRepositoryInterface
{
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function create(int $facilityId, int $userId, string $comment, int $rating): void
    {
        $this->user->findOrFail($userId)->reviews()->create([
            'facility_id' => $facilityId,
            'comment' => $comment,
            'rating' => $rating,
            'status' => ReviewStatus::PUBLIC,
        ]);
    }
}
