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
        $address = Address::factory()->for($municipality, 'municipality')->create();

        $user = User::factory()->for($address, 'address')->create();

        $this->actingAs($user);

        // 同じ自治体の施設
        $facilitySameMunicipality = Facility::factory()
            ->count(500)
            ->for($address, 'address')
            ->create();

        // 別の自治体の施設
        $otherMunicipality = Municipality::factory()->for($prefecture, 'prefecture')->create();
        $otherAddress = Address::factory()->for($otherMunicipality, 'municipality')->create();

        $facilityOtherMunicipality = Facility::factory()
            ->count(100)
            ->for($otherAddress, 'address')
            ->create();

        $result = $this->facilityRepository->getAll($user->address->municipality_id);

        $this->assertInstanceOf(Collection::class, $result);
        foreach ($facilitySameMunicipality as $facility) {
            $this->assertTrue($result->contains($facility));
        }

        foreach ($facilityOtherMunicipality as $facility) {
            $this->assertFalse($result->contains($facility));
        }
    }
}
