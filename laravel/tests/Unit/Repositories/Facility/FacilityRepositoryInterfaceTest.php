<?php

namespace Tests\Unit\Repositories\Facility;

use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

abstract class FacilityRepositoryInterfaceTest extends TestCase
{
    /**
     * 実装クラス
     *
     * @var mixed
     */
    protected $facilityRepository;

    public function testGetAllFacilities(): void
    {
        $result = $this->facilityRepository->getAllFacilities();
        $this->assertInstanceOf(Collection::class, $result);
    }
}
