<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class MainController extends Controller
{
    public function index()
    {
        $week = $this->getWeek();
        return response()->json(['week' => $week]);
    }

    private function getWeek()
    {
        Carbon::setLocale('ja');
        $week = [];
        for ($i=0; $i < 7; $i++) {
            $date = Carbon::today()->addDays($i);
            $week[] = [
                'date' => $date->format('Y-m-d'),
                'day' => $date->isoFormat('ddd'),
            ];
        }
        return $week;
    }
}
