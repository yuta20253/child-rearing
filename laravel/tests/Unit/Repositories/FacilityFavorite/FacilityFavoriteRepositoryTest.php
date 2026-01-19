<?php

namespace Tests\Unit\Repositories\FacilityFavorite;

use App\Models\Facility;
use App\Models\User;
use App\Repositories\FacilityFavorite\FacilityFavoriteRepository;
use App\Repositories\FacilityFavorite\FacilityFavoriteRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FacilityFavoriteRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private FacilityFavoriteRepositoryInterface $facilityFavoriteRepository;
    /**
     * A basic unit test example.
     */
    protected function setUp(): void
    {
        parent::setUp();
        app()->bind(FacilityFavoriteRepositoryInterface::class, FacilityFavoriteRepository::class);
        $this->facilityFavoriteRepository = app(FacilityFavoriteRepositoryInterface::class);
    }

    /**
     * @test
     */
    // phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps
    public function getUserFacilityFavoritesはそのユーザーの施設だけ返す(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $facility1 = Facility::factory()->create();
        $facility2 = Facility::factory()->create();

        $user1->facilityFavorites()->attach($facility1->id);
        $user2->facilityFavorites()->attach($facility2->id);

        $result = $this->facilityFavoriteRepository->getUserFacilityFavorites($user1->id);

        $this->assertCount(1, $result);
        $this->assertEquals($facility1->id, $result->first()->id);
    }

    /**
     * @test
     */
    // phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps
    public function 二回同じuserId、facilityIdでregisterが実行されたときに、レコードが1つのままであること(): void
    {
        $user1 = User::factory()->create();

        $facility1 = Facility::factory()->create();

        $this->facilityFavoriteRepository->register($facility1->id, $user1->id);
        $this->facilityFavoriteRepository->register($facility1->id, $user1->id);

        $this->assertDatabaseCount('facility_favorites', 1);
        $this->assertDatabaseHas('facility_favorites', [
            'user_id' => $user1->id,
            'facility_id' => $facility1->id,
        ]);
    }
    /**
     * @test
     */
    // phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps
    public function registerで中間テーブルにレコードが追加されること(): void
    {
        $user = User::factory()->create();
        $facility = Facility::factory()->create();

        $this->facilityFavoriteRepository->register($facility->id, $user->id);

        $this->assertDatabaseHas('facility_favorites', [
            'user_id' => $user->id,
            'facility_id' => $facility->id,
        ]);
    }

    /**
     * @test
     */
    // phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps
    public function cancelで中間テーブルにレコードが削除されること(): void
    {
        $user = User::factory()->create();
        $facility = Facility::factory()->create();

        $user->facilityFavorites()->syncWithoutDetaching($facility->id);

        $this->facilityFavoriteRepository->cancel($facility->id, $user->id);

        $this->assertDatabaseCount('facility_favorites', 0);

        $this->assertDatabaseMissing('facility_favorites', [
            'user_id' => $user->id,
            'facility_id' => $facility->id,
        ]);
    }
}
