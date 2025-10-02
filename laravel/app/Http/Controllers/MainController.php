<?php

namespace App\Http\Controllers;

use App\Services\CarenderService;
use Illuminate\Http\Request;

class MainController extends Controller
{
    protected CarenderService $carenderService;

    public function __construct(CarenderService $carenderService)
    {
        $this->carenderService = $carenderService;
    }
    public function index()
    {
        $week = $this->carenderService->getCarender();
        return response()->json(['week' => $week]);
    }
}
