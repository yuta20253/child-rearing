<?php

namespace App\Http\Controllers;

use App\Services\FacilityService;
use App\Services\FacilityFavoriteService;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    protected FacilityFavoriteService $facilityFavoriteService;
    protected FacilityService $facilityService;

    public function __construct(
        FacilityFavoriteService $facilityFavoriteService,
        FacilityService $facilityService,
    ) {
        $this->facilityFavoriteService = $facilityFavoriteService;
        $this->facilityService = $facilityService;
    }

    public function index()
    {
        $facilityFavorities = $this->facilityFavoriteService->getFacilityFavorities();
        return response()->json(['facilityFavorities' => $facilityFavorities]);
    }

    public function store(int $facilityId)
    {
        $facility = $this->facilityService->find($facilityId);

        if (! $facility) {
            return response()->json(['message' => '該当の施設が見つかりません。'], 404);
        }

        $this->facilityFavoriteService->registerFacilityFavorite($facility->id);
        return response()->json(['message' => 'お気に入り登録しました。'], 201);
    }

    public function destroy(int $facilityId)
    {
        $facility = $this->facilityService->find($facilityId);

        if (! $facility) {
            return response()->json(['message' => '該当の施設が見つかりません。'], 404);
        }

        $this->facilityFavoriteService->cancelFacilityFavorite(($facility->id));
        return response()->json(['message' => 'お気に入り解除しました。'], 201);
    }
}
