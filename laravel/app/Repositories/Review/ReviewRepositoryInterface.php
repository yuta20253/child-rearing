<?php

namespace App\Repositories\Review;

interface ReviewRepositoryInterface
{
    public function create(int $facilityId, int $userId, string $comment, int $rating): void;
    public function update(int $reviewId, int $userId, string $comment, int $rating): void;
}
