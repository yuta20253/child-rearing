<?php

namespace Tests\Unit\Repositories\Review;

use App\Models\User;
use App\Models\Facility;
use App\Repositories\Review\ReviewRepository;
use App\Repositories\Review\ReviewRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReviewRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private ReviewRepositoryInterface $reviewRepository;

    /**
     * A basic unit test example.
     */
    protected function setUp(): void
    {
        parent::setUp();
        app()->bind(ReviewRepositoryInterface::class, ReviewRepository::class);
        $this->reviewRepository = app(ReviewRepositoryInterface::class);
    }

    /**
     * @test
     */
    // phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps
    public function createでレコードが作成されること(): void
    {
        $facility = Facility::factory()->create();
        $facilityId = $facility->id;
        $comment = 'いい施設';
        $rating = 5;
        $user1 = User::factory()->create();
        $userId = $user1->id;

        $this->reviewRepository->create($facilityId, $userId, $comment, $rating);

        $this->assertDatabaseHas('facility_reviews', [
            'facility_id' => $facilityId,
            'user_id' => $userId,
            'comment' => $comment,
            'rating' => $rating,
            'status' => '公開',
        ]);
    }

    /**
     * @test
     */
    // phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps
    public function 存在しないユーザーIDの場合は例外が発生すること(): void
    {
        $this->expectException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);

        $this->reviewRepository->create(1, 999, 'test', 5);
    }
}
