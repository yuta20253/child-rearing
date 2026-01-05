<?php

namespace Tests\Unit\Services\FacilityFavorite;

use App\Models\Facility;
use App\Repositories\FacilityFavorite\FacilityFavoriteRepositoryInterface;
use App\Services\FacilityFavoriteService;
use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class FacilityFavoriteServiceTest extends TestCase
{
    /** @var FacilityFavoriteRepositoryInterface&\Mockery\MockInterface $facilityFavoriteRepositoryMock */
    private $facilityFavoriteRepositoryMock;
    private FacilityFavoriteService $facilityFavoriteService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->facilityFavoriteRepositoryMock = $this->mock(FacilityFavoriteRepositoryInterface::class);
        $this->facilityFavoriteService = new FacilityFavoriteService($this->facilityFavoriteRepositoryMock);
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
