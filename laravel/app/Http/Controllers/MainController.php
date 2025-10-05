<?php

namespace App\Http\Controllers;

use App\Services\CarenderService;
use App\Services\FacilityFavoriteService;
use App\Services\UserEventService;
use Illuminate\Http\Request;

class MainController extends Controller
{
    protected CarenderService $carenderService;
    protected UserEventService $userEventService;
    protected FacilityFavoriteService $facilityFavoriteService;

    public function __construct(
            CarenderService $carenderService,
            UserEventService $userEventService,
            FacilityFavoriteService $facilityFavoriteService
        )
    {
        $this->carenderService = $carenderService;
        $this->userEventService = $userEventService;
        $this->facilityFavoriteService = $facilityFavoriteService;
    }

    public function index()
    {
        $data['week'] = $this->carenderService->getCarender();
        $data['events'] = $this->userEventService->getUserEvents();
        $data['facilityFavorities'] = $this->facilityFavoriteService->getFacilityFavorities();

        return response()->json(['data' => $data]);
    }
}
