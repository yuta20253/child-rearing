<?php

namespace App\Http\Controllers;

use App\Services\CalenderService;
use App\Services\FacilityFavoriteService;
use Illuminate\Http\Request;

class TopController extends Controller
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

    public function index()
    {
        $year = now()->year;
        $month = now()->month + 1;
        $data['events'] = $this->calenderService->selectedMonthUserEvents($year, $month);
        $data['facilityFavorities'] = $this->facilityFavoriteService->getFacilityFavorities();

        return response()->json(['data' => $data]);
    }
}
