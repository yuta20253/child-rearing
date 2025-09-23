<?php

namespace Tests\Unit\Services\Facility;

use App\Models\Facility;
use App\Repositories\Facility\FacilityRepositoryInterface;
use App\Services\FacilityService;
use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Facades\Auth;
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

    /**
     * @test
     * municipality_id=1 のユーザーなら施設1件
     */
    public function getAllFacilities(): void
    {
        $facilities = new EloquentCollection([
            new Facility(['id' => 1, 'name' => 'Test施設１']),
        ]);

        // ダミーユーザーを作成
        $user = new class {
            public $address;
            public function __construct()
            {
                $this->address = new class {
                    public $municipality_id = 1;
                };
            }
        };

        // Auth::user() をモック
        Auth::shouldReceive('user')->once()->andReturn($user);

        $this->facilityRepositoryMock->shouldReceive('getAll')->with(1)->once()->andReturn($facilities);

        $result = $this->facilityService->getAll();

        $this->assertCount(1, $result);
        $this->assertEquals('Test施設１', $result[0]->name);
    }
    /**
     * @test
     * municipality_id=2 のユーザーなら施設2件
     */
    public function getFacilitiesForMunicipality2(): void
    {
        $facilities = new EloquentCollection([
            new Facility(['id' => 1, 'name' => '施設2-1']),
            new Facility(['id' => 2, 'name' => '施設2-2']),
        ]);

        $user = new class {
            public $address;
            public function __construct()
            {
                $this->address = new class {
                    public $municipality_id = 2;
                };
            }
        };
        Auth::shouldReceive('user')->once()->andReturn($user);

        $this->facilityRepositoryMock->shouldReceive('getAll')->with(2)->once()->andReturn($facilities);

        $result = $this->facilityService->getAll();

        $this->assertCount(2, $result);
        $this->assertEquals('施設2-1', $result[0]->name);
        $this->assertEquals('施設2-2', $result[1]->name);
    }

    /**
     * @test
     * 選択された施設が取得できること
     */
    public function find()
    {
        $facilityId = 1;
        $facility = new Facility();
        $facility->id = $facilityId;
        $facility->name = 'Test施設１';

        $this->facilityRepositoryMock->shouldReceive('find')->with($facility->id)->once()->andReturn($facility);

        $result = $this->facilityService->find($facility->id);

        $this->assertSame($facility, $result);
        $this->assertEquals('Test施設１', $result->name);
    }
}
