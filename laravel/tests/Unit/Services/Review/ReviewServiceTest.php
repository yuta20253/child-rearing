<?php

namespace Tests\Unit\Services\Review;

use Tests\TestCase;
use App\Services\ReviewService;
use App\Repositories\Review\ReviewRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class ReviewServiceTest extends TestCase
{
    /** @var ReviewRepositoryInterface&\Mockery\MockInterface $reviewRepositoryMock */
    private $reviewRepositoryMock;

    private ReviewService $reviewService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->reviewRepositoryMock = $this->mock(ReviewRepositoryInterface::class);
        $this->reviewService =
            new ReviewService(
                $this->reviewRepositoryMock,
            );
    }

    /**
     * @test
     */
    // phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps
    public function createReviewメソッドが認証ユーザーidでRepositoryを呼べること(): void
    {
        $facilityId = 1;
        $comment = 'いい施設';
        $rating = 5;
        $userId = 10;

        Auth::shouldReceive('id')
            ->once()
            ->andReturn($userId);

        $this
            ->reviewRepositoryMock
            ->shouldReceive('create')
            ->once()
            ->with($facilityId, $userId, $comment, $rating);

        $this->reviewService->createReview($facilityId, $comment, $rating);
    }
}
