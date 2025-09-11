<?php

namespace App\Http\Controllers;

use App\Services\FacilityService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
        $facilities = $this->facilityService->getAll();
        return response()->json([
            "facilities" => $facilities,
        ], 200);
    }

    public function show($id)
    {
        try {
            $facility = $this->facilityService->find($id);
            return response()->json(['facility' => $facility], 200);
        } catch (ModelNotFoundException) {
            return response()->json(['message' => '該当の施設が見つかりません。'], 404);
        }
    }
}
