<?php

namespace App\Http\Controllers;

use App\Services\CalenderService;
use App\Services\FacilityFavoriteService;
use App\Services\UserEventService;
use Illuminate\Http\Request;

class TopController extends Controller
{
    protected CalenderService $calenderService;
    protected UserEventService $userEventService;
    protected FacilityFavoriteService $facilityFavoriteService;

    public function __construct(
        CalenderService $calenderService,
        UserEventService $userEventService,
        FacilityFavoriteService $facilityFavoriteService
    ) {
        $this->calenderService = $calenderService;
        $this->userEventService = $userEventService;
        $this->facilityFavoriteService = $facilityFavoriteService;
    }

    public function index(Request $request)
    {
        $startDate = $request->query('start_date');
        $data['week'] = $this->calenderService->getCalender($startDate);
        $data['events'] = $this->userEventService->getUserEvents();
        $data['facilityFavorities'] = $this->facilityFavoriteService->getFacilityFavorities();

        return response()->json(['data' => $data]);
    }
}
