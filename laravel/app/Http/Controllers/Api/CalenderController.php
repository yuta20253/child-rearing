<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CalenderService;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class CalenderController extends Controller
{
    private CalenderService $calenderService;

    public function __construct(CalenderService $calenderService)
    {
        $this->calenderService = $calenderService;
    }

    public function selectMonth(Request $request)
    {
        $events = $this->calenderService->selectedMonthUserEvents($request->year, $request->month);
        return response()->json([
            'events' => $events
        ]) ;
    }
}
