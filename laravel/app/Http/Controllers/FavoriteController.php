<?php

namespace App\Http\Controllers;

use App\Services\CalenderService;
use App\Services\FacilityFavoriteService;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    protected CalenderService $calenderService;
    protected FacilityFavoriteService $facilityFavoriteService;

    public function __construct(
        CalenderService $calenderService,
        FacilityFavoriteService $facilityFavoriteService
    ) {
        $this->calenderService = $calenderService;
        $this->facilityFavoriteService = $facilityFavoriteService;
    }

    public function index(Request $request)
    {
        // $year = now()->year;
        // $month = now()->month + 1;
        $data['events'] = $this->calenderService->selectedMonthUserEvents($request->year, $request->month);
        $data['facilityFavorities'] = $this->facilityFavoriteService->getFacilityFavorities();

        return response()->json(['data' => $data]);
    }
}
