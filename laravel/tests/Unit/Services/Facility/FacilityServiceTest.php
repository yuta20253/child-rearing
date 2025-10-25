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
     */
    // phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps
    public function municipality_idが1のユーザーなら施設1件(): void
    {
        $facilities = new EloquentCollection([
            tap(new Facility(['id' => 1, 'name' => 'Test施設１']), function ($facility) {
                $facility->setRelation('address', new class {
                    public $municipality_id = 1;
                });
            }),
            tap(new Facility(['id' => 2, 'name' => 'Test施設２']), function ($facility) {
                $facility->setRelation('address', new class {
                    public $municipality_id = 2;
                });
            }),
            tap(new Facility(['id' => 3, 'name' => 'Test施設３']), function ($facility) {
                $facility->setRelation('address', new class {
                    public $municipality_id = 1;
                });
            }),
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

        $filterFacilities = $facilities->filter(function ($facility) {
            return $facility->municipality_id === 1;
        });


        $this->facilityRepositoryMock->shouldReceive('getAll')->with(1, null)->once()->andReturn($filterFacilities);

        $result = $this->facilityService->getAll();

        $this->assertCount(2, $result);
        foreach ($result as $facility) {
            $this->assertEquals(1, $facility->municipality_id);
        }
    }
}
