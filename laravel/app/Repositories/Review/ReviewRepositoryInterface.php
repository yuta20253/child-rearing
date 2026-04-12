<?php

namespace App\Repositories\Review;

interface ReviewRepositoryInterface
{
    public function store(int $facilityId, int $userId, string $comment, int $rating);
}
