<?php

namespace Tests\Unit\Repositories\Facility;

use App\Models\Address;
use App\Models\Facility;
use App\Models\Prefecture;
use App\Models\Municipality;
use App\Models\User;
use App\Repositories\Facility\FacilityRepository;
use App\Repositories\Facility\FacilityRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FacilityRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private FacilityRepositoryInterface $facilityRepository;
    /**
     * A basic unit test example.
     */
    protected function setUp(): void
    {
        parent::setUp();
        app()->bind(FacilityRepositoryInterface::class, FacilityRepository::class);
        $this->facilityRepository = app(FacilityRepositoryInterface::class);
    }

    /**
     * @test
     */
    // phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps
    public function 同じ市区町村の施設だけが返却されること(): void
    {
        $prefecture = Prefecture::factory()->create();
        $municipality = Municipality::factory()->for($prefecture, 'prefecture')->create();
        $otherMunicipality = Municipality::factory()->for($prefecture, 'prefecture')->create();
        $address = Address::factory()->for($municipality, 'municipality')->create();
        $otherAddress = Address::factory()->for($otherMunicipality, 'municipality')->create();

        $facilitySameMunicipality = Facility::factory()
            ->for($address, 'address')
            ->create();

        Facility::factory()
            ->count(2)
            ->for($otherAddress, 'address')
            ->create();

        $result = $this->facilityRepository->getAll($address->municipality_id, null);

        $this->assertCount(1, $result);

        $this->assertEquals($facilitySameMunicipality->name, $result->first()->name);
        $this->assertTrue($result->contains($facilitySameMunicipality));
    }

    /**
     * @test
     */
    // phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps
    public function nameパラメータで部分一致検索ができること(): void
    {
        $prefecture = Prefecture::factory()->create();
        $municipality = Municipality::factory()->for($prefecture, 'prefecture')->create();
        $address = Address::factory()->for($municipality, 'municipality')->create();
        Facility::factory()->for($address, 'address')->create(['name' => '北区役所']);
        Facility::factory()->for($address, 'address')->create(['name' => '南区図書館']);
        Facility::factory()->for($address, 'address')->create(['name' => '中央公園']);

        $result = $this->facilityRepository->getAll($address->municipality_id, '区');

        $this->assertCount(2, $result);

        $result = $this->facilityRepository->getAll($address->municipality_id, '北');

        $this->assertCount(1, $result);
    }

    /**
     * @test
     */
    // phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps
    public function 指定したIDの施設が取得できること(): void
    {
        $prefecture = Prefecture::factory()->create();
        $municipality = Municipality::factory()->for($prefecture, 'prefecture')->create();
        $address = Address::factory()->for($municipality, 'municipality')->create();

        $facilitySameMunicipality = Facility::factory()->for($address, 'address')->create();

        $result = $this->facilityRepository->find($facilitySameMunicipality->id);

        $this->assertEquals($facilitySameMunicipality->id, $result->id);

        $this->assertTrue($facilitySameMunicipality->is($result));
    }

    /**
     * @test
     */
    // phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps
    public function 指定したIDの施設が存在しないときに例外が入ること(): void
    {
        $this->expectException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);
        $this->facilityRepository->find(99999);
    }
}
