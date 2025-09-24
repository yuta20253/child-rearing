<?php

namespace Tests\Unit\Services\Facility;

use App\Models\Facility;
use App\Repositories\Facility\FacilityRepositoryInterface;
use App\Services\FacilityService;
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
     */
    public function municipality_idが1のユーザーなら施設1件(): void
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
}
