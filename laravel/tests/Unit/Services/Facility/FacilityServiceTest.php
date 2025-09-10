<?php

namespace Tests\Unit\Services\Facility;

use App\Models\Facility;
use App\Repositories\Facility\FacilityRepositoryInterface;
use App\Services\FacilityService;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Tests\TestCase;

class FacilityServiceTest extends TestCase
{

    /** @var FacilityRepositoryInterface&\Mockery\MockInterface $facilityRepositoryMock */
    private $facilityRepositoryMock;
    private FacilityService $facilityService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->facilityRepositoryMock = $this->mock(FacilityRepositoryInterface::class);
        $this->facilityService = new FacilityService($this->facilityRepositoryMock);
    }

    public function testGetAllFacilities(): void
    {
        $facilities = new EloquentCollection([
            new Facility(['id' => 1, 'name' => 'Test施設１']),
            new Facility(['id' => 2, 'name' => 'Test施設2'])
        ]);

        $this->facilityRepositoryMock->shouldReceive('getAllFacilities')->once()->andReturn($facilities);

        $result = $this->facilityService->getAllFacilities();

        $this->assertCount(2, $result);
        $this->assertEquals('Test施設１', $result[0]->name);
        $this->assertEquals('Test施設2', $result[1]->name);
    }
}
