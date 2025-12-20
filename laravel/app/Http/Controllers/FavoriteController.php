<?php

namespace App\Http\Controllers;

use App\Services\FacilityFavoriteService;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    protected FacilityFavoriteService $facilityFavoriteService;

    public function __construct(
        FacilityFavoriteService $facilityFavoriteService
    ) {
        $this->facilityFavoriteService = $facilityFavoriteService;
    }

    public function index()
    {
        $facilityFavorities = $this->facilityFavoriteService->getFacilityFavorities();
        return response()->json(['facilityFavorities' => $facilityFavorities]);
    }
}
