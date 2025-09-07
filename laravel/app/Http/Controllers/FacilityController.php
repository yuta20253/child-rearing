<?php

namespace App\Http\Controllers;

use App\Services\FacilityService;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    private FacilityService $facilityService;

    public function __construct(FacilityService $facilityService)
    {
        $this->facilityService = $facilityService;
    }

    public function index()
    {
        $facilities = $this->facilityService->getAllFacilities();
        return response()->json([
            "facilities" => $facilities,
        ], 200);
    }
}
