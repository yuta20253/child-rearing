<?php

namespace Tests\Unit\Repositories\Facility;

use App\Models\Address;
use App\Models\Facility;
use App\Models\Prefecture;
use App\Models\Municipality;
use App\Models\User;
use App\Repositories\Facility\FacilityRepository;
use App\Repositories\Facility\FacilityRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FacilityRepositoryTest extends FacilityRepositoryInterfaceTest
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     */
    protected function setUp(): void
    {
        parent::setUp();
        app()->bind(FacilityRepositoryInterface::class, FacilityRepository::class);
        $this->facilityRepository = app(FacilityRepositoryInterface::class);
    }

    public function testGetAllFacilities(): void
    {
        $prefecture = Prefecture::factory()->create();
        $municipality = Municipality::factory()->for($prefecture, 'prefecture')->create();
        $otherMunicipality = Municipality::factory()->for($prefecture, 'prefecture')->create();
        $address = Address::factory()->for($municipality, 'municipality')->create();
        $otherAddress = Address::factory()->for($otherMunicipality, 'municipality')->create();

        $user = User::factory()->for($address, 'address')->create();

        $this->actingAs($user);

        $facilitySameMunicipality = Facility::factory()
            ->for($address, 'address')
            ->create();

        Facility::factory()
            ->count(2)
            ->for($otherAddress, 'address')
            ->create();

        $result = $this->facilityRepository->getAll($user->address->municipality_id);

        $this->assertCount(1, $result);

        $this->assertEquals($facilitySameMunicipality->name, $result->first()->name);
        $this->assertTrue($result->contains($facilitySameMunicipality));
    }
}
