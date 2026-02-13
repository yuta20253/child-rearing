<?php

namespace Tests\Unit\Services\FacilityFavorite;

use App\Repositories\FacilityFavorite\FacilityFavoriteRepositoryInterface;
use App\Repositories\Facility\FacilityRepositoryInterface;
use App\Services\FacilityFavoriteService;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class FacilityFavoriteServiceTest extends TestCase
{
    /** @var FacilityFavoriteRepositoryInterface&\Mockery\MockInterface $facilityFavoriteRepositoryMock */
    private $facilityFavoriteRepositoryMock;

    /** @var FacilityRepositoryInterface&\Mockery\MockInterface */
    private $facilityRepositoryMock;

    private FacilityFavoriteService $facilityFavoriteService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->facilityFavoriteRepositoryMock = $this->mock(FacilityFavoriteRepositoryInterface::class);
        $this->facilityRepositoryMock = $this->mock(FacilityRepositoryInterface::class);
        $this->facilityFavoriteService =
            new FacilityFavoriteService(
                $this->facilityFavoriteRepositoryMock,
                $this->facilityRepositoryMock
            );
    }

    /**
     * @test
     */
    // phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps
    public function registerメソッドが認証ユーザーidでRepositoryを呼べること(): void
    {
        Auth::shouldReceive('id')->once()->andReturn(1);
        $this->facilityFavoriteRepositoryMock
             ->shouldReceive('register')
             ->once()
             ->with(123, 1);

        $this->facilityFavoriteService->register(123);

        $this->assertTrue(true);
    }

    /**
     * @test
     */
    // phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps
    public function cancelメソッドが認証ユーザーidでRepositoryを呼べること(): void
    {
        Auth::shouldReceive('id')->once()->andReturn(1);
        $this->facilityFavoriteRepositoryMock
             ->shouldReceive('cancel')
             ->once()
             ->with(123, 1);

        $this->facilityFavoriteService->cancel(123);
        $this->assertTrue(true);
    }
}
