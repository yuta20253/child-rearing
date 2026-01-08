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
        $facilityFavorites = $this->facilityFavoriteService->getFacilityFavorites();
        return response()->json(['facilityFavorites' => $facilityFavorites]);
    }

    public function store(string $facilityId)
    {
        $facility = $this->facilityService->find($facilityId);

        if (! $facility) {
            return response()->json(['message' => '該当の施設が見つかりません。'], 404);
        }

        $this->facilityFavoriteService->register($facility->id);
        return response()->json(['message' => 'お気に入り登録しました。'], 201);
    }

    public function destroy(string $facilityId)
    {
        $facility = $this->facilityService->find($facilityId);

        if (! $facility) {
            return response()->json(['message' => '該当の施設が見つかりません。'], 404);
        }

        $this->facilityFavoriteService->cancel(($facility->id));
        return response()->json(['message' => 'お気に入り解除しました。'], 201);
    }
}
