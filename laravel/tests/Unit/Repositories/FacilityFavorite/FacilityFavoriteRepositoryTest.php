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
    public function getUserFacilityFavoritiesはそのユーザーの施設だけ返す(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $facility1 = Facility::factory()->create();
        $facility2 = Facility::factory()->create();

        $user1->facilityFavorities()->attach($facility1->id);
        $user2->facilityFavorities()->attach($facility2->id);

        $result = $this->facilityFavoriteRepository->getUserFacilityFavorities($user1->id);

        $this->assertCount(1, $result);
        $this->assertEquals($facility1->id, $result->first()->id);
    }

    /**
     * @test
     */
    // phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps
    public function registerUserFacilityFavoriteで中間テーブルにレコードが追加されること(): void
    {
        $user = User::factory()->create();
        $facility = Facility::factory()->create();

        $this->facilityFavoriteRepository->registerUserFacilityFavorite($facility->id, $user->id);

        $this->assertDatabaseHas('facility_favorites', [
            'user_id' => $user->id,
            'facility_id' => $facility->id,
        ]);
    }

    /**
     * @test
     */
    // phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps
    public function cancelUserFacilityFavoriteで中間テーブルにレコードが削除されること(): void
    {
        $user = User::factory()->create();
        $facility = Facility::factory()->create();

        $this->facilityFavoriteRepository->cancelUserFacilityFavorite($facility->id, $user->id);

        $this->assertDatabaseMissing('facility_favorites', [
            'user_id' => $user->id,
            'facility_id' => $facility->id,
        ]);
    }
}
